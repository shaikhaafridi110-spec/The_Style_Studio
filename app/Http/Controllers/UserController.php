<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
   public function chatbot(Request $r)
{
    $r->validate(['message' => 'required|string|max:500']);

    // ── 1. All Products with sizes, category, reviews ─────────
    $products = \App\Models\Product::with(['category', 'productsize', 'reviews'])
        ->where('status', 1)
        ->get()
        ->map(function($p) {
            $sizes        = $p->productsize->where('stock', '>', 0)->pluck('size')->implode(', ');
            $category     = $p->category ? $p->category->name : 'N/A';
            $price        = ($p->discount_price > 0) ? $p->discount_price : $p->price;
            $discount     = ($p->discount_price > 0) ? ' (Original: ₹' . $p->price . ')' : '';
            $avgRating    = $p->reviews->count() > 0 ? round($p->reviews->avg('rating'), 1) : 'No reviews';
            $totalReviews = $p->reviews->count();
            return "- {$p->proname} | Category: {$category} | Price: ₹{$price}{$discount} | Sizes: {$sizes} | Rating: {$avgRating}/5 ({$totalReviews} reviews)";
        })
        ->implode("\n");

    // ── 2. Most Reviewed Products (top 5) ─────────────────────
    $mostReviewed = \App\Models\Product::with(['reviews'])
        ->where('status', 1)
        ->get()
        ->filter(fn($p) => $p->reviews->count() > 0)
        ->sortByDesc(fn($p) => $p->reviews->count())
        ->take(5)
        ->map(function($p) {
            $avgRating = round($p->reviews->avg('rating'), 1);
            $price     = ($p->discount_price > 0) ? $p->discount_price : $p->price;
            return "- {$p->proname} | ₹{$price} | ⭐{$avgRating}/5 | {$p->reviews->count()} reviews";
        })
        ->implode("\n");

    // ── 3. Most Ordered Products (top 5) ──────────────────────
    $mostOrdered = \App\Models\OrderItem::select('product_name')
        ->selectRaw('SUM(qty) as total_qty')
        ->groupBy('product_name')
        ->orderByDesc('total_qty')
        ->take(5)
        ->get()
        ->map(fn($item) => "- {$item->product_name} | Ordered {$item->total_qty} times")
        ->implode("\n");

    // ── 4. Top Rated Products (top 5) ─────────────────────────
    $topRated = \App\Models\Product::with(['reviews'])
        ->where('status', 1)
        ->get()
        ->filter(fn($p) => $p->reviews->count() > 0)
        ->map(function($p) {
            $p->avg_rating = round($p->reviews->avg('rating'), 1);
            return $p;
        })
        ->filter(fn($p) => $p->avg_rating >= 4)
        ->sortByDesc('avg_rating')
        ->take(5)
        ->map(function($p) {
            $price = ($p->discount_price > 0) ? $p->discount_price : $p->price;
            return "- {$p->proname} | ₹{$price} | ⭐{$p->avg_rating}/5";
        })
        ->implode("\n");

    // ── 5. Categories ──────────────────────────────────────────
    $categories = \App\Models\Category::where('status', 1)
        ->pluck('name')
        ->implode(', ');

    // ── 6. System Prompt ───────────────────────────────────────
    $systemPrompt = '
You are a helpful shopping assistant for Style Studio, a fashion e-commerce store in India.
Keep replies short, friendly and in simple English. Prices are in Indian Rupees (₹).
Only answer questions related to fashion, clothing, shopping and Style Studio.

━━━━━━━━━━━━━━━━━━━━━━━
WEBSITE PAGES (REDIRECT only when user explicitly asks to go/open/take me/navigate):
━━━━━━━━━━━━━━━━━━━━━━━
- Shop / Browse products    → REDIRECT:shop
- My Cart                   → REDIRECT:cart
- My Orders / Track order   → REDIRECT:orders
- My Wishlist               → REDIRECT:wishlist
- My Profile                → REDIRECT:profile
- Categories                → REDIRECT:categories
- About Us                  → REDIRECT:about
- Contact Us / Help         → REDIRECT:contact
- Home                      → REDIRECT:home

STRICT REDIRECT RULES:
- ONLY use REDIRECT tag when user says words like: "go to", "open", "take me", "show me the page", "redirect", "navigate", "visit page".
- NEVER use REDIRECT for product questions like "what sizes", "show products", "price of", "best products" etc.
- For product questions just answer normally with NO redirect.

Examples:
- "what sizes does kurti have?" → answer normally, NO redirect
- "go to shop" → answer + REDIRECT:shop
- "open my cart" → answer + REDIRECT:cart
- "take me to orders" → answer + REDIRECT:orders
- "show me sarees price" → answer normally, NO redirect
- "take me to wishlist" → answer + REDIRECT:wishlist

IMPORTANT: When user wants to go to any page, end your reply with the REDIRECT tag on a new line.
Example: "Sure! Taking you to the shop. REDIRECT:shop"

━━━━━━━━━━━━━━━━━━━━━━━
FULL PRODUCT CATALOG (live):
━━━━━━━━━━━━━━━━━━━━━━━
' . ($products ?: 'No products available.') . '

━━━━━━━━━━━━━━━━━━━━━━━
MOST REVIEWED PRODUCTS:
━━━━━━━━━━━━━━━━━━━━━━━
' . ($mostReviewed ?: 'No reviews yet.') . '

━━━━━━━━━━━━━━━━━━━━━━━
MOST ORDERED PRODUCTS:
━━━━━━━━━━━━━━━━━━━━━━━
' . ($mostOrdered ?: 'No orders yet.') . '

━━━━━━━━━━━━━━━━━━━━━━━
TOP RATED PRODUCTS:
━━━━━━━━━━━━━━━━━━━━━━━
' . ($topRated ?: 'No top rated products yet.') . '

━━━━━━━━━━━━━━━━━━━━━━━
CATEGORIES:
━━━━━━━━━━━━━━━━━━━━━━━
' . ($categories ?: 'No categories available.') . '

━━━━━━━━━━━━━━━━━━━━━━━
STORE POLICIES:
━━━━━━━━━━━━━━━━━━━━━━━
- Return & Refund: No return and no refund. All sales are final.
- Shipping: Free shipping on orders above ₹999.
- Payment: UPI, Credit/Debit Card, Net Banking and Cash on Delivery.
- Delivery: 3-7 working days across India.
- Support: Call us 24/7 at +0123 456 789.

━━━━━━━━━━━━━━━━━━━━━━━
RULES:
━━━━━━━━━━━━━━━━━━━━━━━
- Use ONLY the catalog above for product, size and price answers.
- If a product is not listed, say it is currently unavailable.
- If a size has no stock, say it is out of stock.
- Recommend most ordered or top rated products when asked for suggestions.
- Never make up products, sizes or prices not in the catalog.
- No coupons or discount codes are available right now.
- For return or refund questions, clearly say no return and no refund policy.
- Always use REDIRECT tag when user wants to navigate to any page.
';

    // ── 7. Call Groq API ───────────────────────────────────────
    $response = \Illuminate\Support\Facades\Http::timeout(15)
        ->withHeaders([
            'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
            'Content-Type'  => 'application/json',
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model'       => 'llama-3.1-8b-instant',
            'max_tokens'  => 500,
            'temperature' => 0.5,
            'messages'    => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user',   'content' => $r->message]
            ]
        ]);

    $data = $response->json();

    if (isset($data['error'])) {
        \Log::info('Groq Error: ' . json_encode($data['error']));
        return response()->json([
            'reply'    => 'Sorry, I am unable to respond right now. Please try again later.',
            'redirect' => null
        ]);
    }

    $reply = $data['choices'][0]['message']['content'] ?? 'Sorry, I could not understand that.';

    // ── 8. Extract REDIRECT tag ────────────────────────────────
    $redirect = null;
    if (preg_match('/REDIRECT:(\w+)/i', $reply, $matches)) {
        $redirect = $matches[1];
        $reply    = trim(preg_replace('/REDIRECT:\w+/i', '', $reply));
    }

    return response()->json([
        'reply'    => $reply,
        'redirect' => $redirect
    ]);
}
    public function allCategories()
    {
       $categories = \App\Models\Category::where('status', '1')
    ->withCount(['product' => fn($q) => $q->where('status', 'active')])
    ->having('product_count', '>', 0)
    ->get();
                  

        return view('user.categories', compact('categories'));
    }
    public function fcupon(Request $r)
    {
        $r->validate(['email' => 'required|email']);

        $email = $r->email;

        // 1. Find user by email
        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->with('fcupon_error', 'No account found with this email address.');
        }

        // 2. Check if user has at least one order
        $orderCount = $user->orders()->count();
        print_r($orderCount);
        die;

        if ($orderCount === 0) {
            return back()->with('fcupon_error', 'You have no orders yet. Place your first order to be eligible for a coupon!');
        }

        // 3. Prevent duplicate: one coupon per user
        $alreadyGiven = Coupon::where('code', 'LIKE', 'REWARD-' . $user->id . '-%')->exists();

        if ($alreadyGiven) {
            return back()->with('fcupon_error', 'You have already received your reward coupon!');
        }

        // 4. Generate unique coupon code
        $couponCode = 'REWARD-' . $user->id . '-' . strtoupper(Str::random(6));

        // 5. Save coupon to DB
        Coupon::create([
            'code'        => $couponCode,
            'discount'    => 200,
            'type'        => 'fixed',
            'expiry_date' => now()->addDays(30),
            'usage_limit' => 1,
            'used_count'  => 0,
            'status'      => 1,
        ]);

        // 6. Send email
        Mail::raw(
            "Hello {$user->name},

Thank you for being a valued Style Studio customer! 🎉

We're rewarding you with an exclusive ₹200 coupon:

━━━━━━━━━━━━━━━━━━━━━━
   COUPON CODE: {$couponCode}
━━━━━━━━━━━━━━━━━━━━━━

  ✅ Discount  : ₹200 OFF
  ✅ Valid For : 30 Days
  ✅ Usage     : One-time use only

How to use:
  → Visit our shop and add items to your cart
  → Enter the coupon code at checkout
  → Enjoy ₹200 off instantly!

This offer expires on: " . now()->addDays(30)->format('d M Y') . "

Happy Shopping!
The Style Studio Team
--------------------------------------
If you did not request this coupon, please ignore this email.",
            function ($message) use ($email) {
                $message->to($email)
                    ->subject('🎁 Your Exclusive ₹200 Style Studio Coupon');
            }
        );

        return back()->with('fcupon_success', 'A ₹200 coupon has been sent to ' . $email . '!');
    }
    public function index()
    {
        // ALL products for trendy section
        $trendyAll = Product::with('category')
            ->where('status', 'active')

            ->take(13)
            ->get();

        // Products by category slug for tabs
        $trendyWomen = Product::with('category')
            ->whereHas('category', fn($q) => $q->wherein('slug', ['women-jeans', 'women-top', 'women-dress']))
            ->where('status', 'active')
            ->latest()->take(8)->get();

        $trendyMen = Product::with('category')
            ->whereHas('category', fn($q) => $q->wherein('slug', ['men-shirt', 'men-jeans', 'men-tshirt']))
            ->where('status', 'active')
            ->latest()->take(8)->get();



        // New arrivals
        $newAll = Product::with('category')
            ->where('status', 'active')
            ->latest()
            ->take(8)
            ->get();

        $newClothing = Product::with('category')
            ->where('status', 'active')
            ->latest()->take(8)->get();





        return view('user.index', compact(
            'trendyAll',
            'trendyWomen',
            'trendyMen',
            'newAll',
            'newClothing'
        ));
    }




    public function wishlist()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $wishlist = Wishlist::with(['product.category', 'product.productsize'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('user.wishlist', compact('wishlist', 'cartItems'));
    }
    public function about()
    {
        return view('user.about');
    }
}

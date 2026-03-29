<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class dummydata extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
         DB::table('order_items')->insert([

            // Order 1 (4 items)
            ['order_id'=>1,'product_id'=>7,'product_name'=>'Formal White Shirt','product_image'=>'products/1774520214.jpg','original_price'=>1499,'discount_amount'=>100,'tax_amount'=>50,'final_price'=>1449,'qty'=>1,'size'=>'M','subtotal'=>1449,'status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['order_id'=>1,'product_id'=>8,'product_name'=>'Printed Shirt','product_image'=>'products/1774521437.jpg','original_price'=>1699,'discount_amount'=>100,'tax_amount'=>60,'final_price'=>1659,'qty'=>1,'size'=>'L','subtotal'=>1659,'status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['order_id'=>1,'product_id'=>10,'product_name'=>'Basic Black T-Shirt','product_image'=>'products/1774525956.jpg','original_price'=>799,'discount_amount'=>0,'tax_amount'=>40,'final_price'=>839,'qty'=>1,'size'=>'L','subtotal'=>839,'status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['order_id'=>1,'product_id'=>11,'product_name'=>'Graphic T-Shirt','product_image'=>'products/1774526396.jpg','original_price'=>999,'discount_amount'=>50,'tax_amount'=>45,'final_price'=>994,'qty'=>1,'size'=>'XL','subtotal'=>994,'status'=>'active','created_at'=>now(),'updated_at'=>now()],

            // Order 2 (4 items)
            ['order_id'=>2,'product_id'=>9,'product_name'=>'Half Sleeve Shirt','product_image'=>'products/1774524594.jpg','original_price'=>1299,'discount_amount'=>50,'tax_amount'=>50,'final_price'=>1299,'qty'=>1,'size'=>'M','subtotal'=>1299,'status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['order_id'=>2,'product_id'=>12,'product_name'=>'Oversized T-Shirt','product_image'=>'products/1774526694.jpg','original_price'=>1199,'discount_amount'=>100,'tax_amount'=>50,'final_price'=>1149,'qty'=>1,'size'=>'XL','subtotal'=>1149,'status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['order_id'=>2,'product_id'=>13,'product_name'=>'Slim Fit Jeans','product_image'=>'products/1774527112.jpg','original_price'=>2199,'discount_amount'=>200,'tax_amount'=>100,'final_price'=>2099,'qty'=>1,'size'=>'32','subtotal'=>2099,'status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['order_id'=>2,'product_id'=>14,'product_name'=>'Regular Fit Jeans','product_image'=>'products/1774527665.jpg','original_price'=>1999,'discount_amount'=>100,'tax_amount'=>90,'final_price'=>1989,'qty'=>1,'size'=>'34','subtotal'=>1989,'status'=>'active','created_at'=>now(),'updated_at'=>now()],

            // Order 3 (4 items)
            ['order_id'=>3,'product_id'=>15,'product_name'=>'Ripped Jeans','product_image'=>'products/1774528064.jpg','original_price'=>2599,'discount_amount'=>200,'tax_amount'=>120,'final_price'=>2519,'qty'=>1,'size'=>'32','subtotal'=>2519,'status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['order_id'=>3,'product_id'=>16,'product_name'=>'Floral Dress','product_image'=>'products/1774529065.jpg','original_price'=>2299,'discount_amount'=>100,'tax_amount'=>100,'final_price'=>2299,'qty'=>1,'size'=>'M','subtotal'=>2299,'status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['order_id'=>3,'product_id'=>17,'product_name'=>'Evening Gown','product_image'=>'products/1774529458.jpg','original_price'=>4999,'discount_amount'=>500,'tax_amount'=>200,'final_price'=>4699,'qty'=>1,'size'=>'L','subtotal'=>4699,'status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['order_id'=>3,'product_id'=>18,'product_name'=>'Casual Midi Dress','product_image'=>'products/1774530160.jpg','original_price'=>1899,'discount_amount'=>100,'tax_amount'=>80,'final_price'=>1879,'qty'=>1,'size'=>'M','subtotal'=>1879,'status'=>'active','created_at'=>now(),'updated_at'=>now()],

            // Order 4 (4 items)
            ['order_id'=>4,'product_id'=>19,'product_name'=>'Crop Top','product_image'=>'products/1774531312.jpg','original_price'=>999,'discount_amount'=>50,'tax_amount'=>40,'final_price'=>989,'qty'=>1,'size'=>'S','subtotal'=>989,'status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['order_id'=>4,'product_id'=>20,'product_name'=>'Sleeveless Top','product_image'=>'products/1774531688.jpg','original_price'=>899,'discount_amount'=>0,'tax_amount'=>40,'final_price'=>939,'qty'=>1,'size'=>'M','subtotal'=>939,'status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['order_id'=>4,'product_id'=>21,'product_name'=>'Printed Top','product_image'=>'products/1774532846.jpg','original_price'=>1199,'discount_amount'=>100,'tax_amount'=>50,'final_price'=>1149,'qty'=>1,'size'=>'L','subtotal'=>1149,'status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['order_id'=>4,'product_id'=>22,'product_name'=>'High Waist Jeans','product_image'=>'products/1774541960.jpg','original_price'=>2399,'discount_amount'=>200,'tax_amount'=>100,'final_price'=>2299,'qty'=>1,'size'=>'30','subtotal'=>2299,'status'=>'active','created_at'=>now(),'updated_at'=>now()],

            // Order 5 (4 items)
            ['order_id'=>5,'product_id'=>23,'product_name'=>'Skinny Fit Jeans','product_image'=>'products/1774542398.jpg','original_price'=>2199,'discount_amount'=>100,'tax_amount'=>90,'final_price'=>2189,'qty'=>1,'size'=>'32','subtotal'=>2189,'status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['order_id'=>5,'product_id'=>24,'product_name'=>'Relaxed Fit Jeans','product_image'=>'products/1774544430.jpg','original_price'=>2499,'discount_amount'=>200,'tax_amount'=>100,'final_price'=>2399,'qty'=>1,'size'=>'30','subtotal'=>2399,'status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['order_id'=>5,'product_id'=>10,'product_name'=>'Basic Black T-Shirt','product_image'=>'products/1774525956.jpg','original_price'=>799,'discount_amount'=>0,'tax_amount'=>40,'final_price'=>839,'qty'=>1,'size'=>'XL','subtotal'=>839,'status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['order_id'=>5,'product_id'=>11,'product_name'=>'Graphic T-Shirt','product_image'=>'products/1774526396.jpg','original_price'=>999,'discount_amount'=>50,'tax_amount'=>45,'final_price'=>994,'qty'=>1,'size'=>'L','subtotal'=>994,'status'=>'active','created_at'=>now(),'updated_at'=>now()],

        ]);
    
    }
}

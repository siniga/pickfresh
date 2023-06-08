<?php

namespace Database\Seeders;

use App\Models\CustomerStat;
use App\Models\Region;
use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RegionSeeder::class);
        $this->call(DistrictSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(BusinessTypeSeeder::class);
        $this->call(BusinessSeeder::class);
        $this->call(CampaignTypeSeeder::class);
        $this->call(CampaignSeeder::class);
        $this->call(CustomerTypeSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(TeamSeeder::class);
        $this->call(TeamUserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(SkuSeeder::class);
        $this->call(ProductSkuSeeder::class);
        $this->call(ProductUnitSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(OrderProductSeeder::class);
        $this->call(CustomerUserSeeder::class);
        $this->call(CustomerStatSeeder::class);
      
    
    }
}

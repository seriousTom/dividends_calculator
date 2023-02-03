<?php

namespace Database\Seeders;

use App\Models\Industry;
use App\Models\Sector;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectorsAndIndustriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //thanks chatGPT for this :D
        $sectors = array(
            array(
                "Name" => "Consumer Discretionary",
                "Industries" => array(
                    "Automobiles and Components",
                    "Consumer Durables and Apparel",
                    "Consumer Services",
                    "Homebuilders",
                    "Household Durables",
                    "Leisure Products",
                    "Media",
                    "Retail - Discretionary",
                    "Internet and Direct Marketing Retail"
                )
            ),
            array(
                "Name" => "Consumer Staples",
                "Industries" => array(
                    "Food and Staples Retailing",
                    "Food Products",
                    "Household Products",
                    "Personal Products",
                    "Tobacco"
                )
            ),
            array(
                "Name" => "Energy",
                "Industries" => array(
                    "Oil, Gas and Consumable Fuels",
                    "Oil and Gas Exploration and Production",
                    "Oil Equipment, Services and Distribution",
                    "Integrated Oil and Gas"
                )
            ),
            array(
                "Name" => "Financials",
                "Industries" => array(
                    "Banking",
                    "Capital Markets",
                    "Diversified Financial Services",
                    "Insurance",
                    "Real Estate Management and Development"
                )
            ),
            array(
                "Name" => "Health Care",
                "Industries" => array(
                    "Health Care Equipment and Supplies",
                    "Health Care Providers and Services",
                    "Health Care Technology",
                    "Life Sciences Tools and Services",
                    "Pharmaceuticals, Biotechnology and Life Sciences"
                )
            ),
            array(
                "Name" => "Industrials",
                "Industries" => array(
                    "Aerospace and Defense",
                    "Building Products",
                    "Construction and Engineering",
                    "Commercial Services and Supplies",
                    "Electrical Equipment",
                    "Industrial Conglomerates",
                    "Professional Services",
                    "Road and Rail"
                )
            ),
            array(
                "Name" => "Information Technology",
                "Industries" => array(
                    "Communication Equipment",
                    "Electronic Equipment, Instruments and Components",
                    "Software and Services",
                    "Technology Hardware, Storage and Peripherals"
                )
            ),
            array(
                "Name" => "Materials",
                "Industries" => array(
                    "Chemicals",
                    "Construction Materials",
                    "Containers and Packaging",
                    "Metals and Mining",
                    "Paper and Forest Products"
                )
            ),
            array(
                "Name" => "Real Estate",
                "Industries" => array(
                    "Equity Real Estate Investment Trusts (REITs)",
                    "Real Estate Management and Development"
                )
            ),
            array(
                "Name" => "Telecommunication Services",
                "Industries" => array(
                    "Diversified Telecommunication Services",
                    "Telecommunication Services"
                )
            ),
            array(
                "Name" => "Utilities",
                "Industries" => array(
                    "Electric Utilities",
                    "Gas Utilities",
                    "Multi-Utilities",
                    "Water Utilities"
                )
            )
        );

        foreach ($sectors as $sector) {
            $s = Sector::firstOrCreate(['name' => $sector['Name']]);
            foreach ($sector['Industries'] as $industry) {
                Industry::firstOrCreate([
                    'name' => $industry,
                ], [
                    'sector_id' => $s->id
                ]);
            }
        }
    }
}

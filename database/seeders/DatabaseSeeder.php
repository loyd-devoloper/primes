<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // \App\Models\RecruitmentPsbGrade::create([
        //     'id_number'=>'93668bf8-07bb-4bba-a795-92a355c598d0',
        //     'job_id'=>'5299ac77-36e7-4be1-b962-dc832a64e058',
        //     'batch_id'=>'b6810be8-1350-4005-8aa2-d4a3e968d5d0',
        //     'applicant_id'=>'100'
        // ]);
        // DB::statement(" INSERT INTO `tbl_fd` (`division_id`, `division_name`, `division_short_name`, `division_code`, `division_email`, `office_level_id`, `fd_chief`, `chief_designation`) VALUES
        // (1, 'Office of the Regional Director', 'ORD', '01', '', 1, 'Atty. Alberto T. Escobarte, CESO II', 'Regional Director'),
        // (2, 'Office of the Assistant Regional Director', 'OARD', '01A', '', 1, 'Loida N. Nidea', 'Assistant Regional Director'),
        // (3, 'Public Affairs Unit', 'PAU', '01B', '', 1, 'Ariel M. Azuelo', 'AO V'),
        // (4, 'Legal Unit', 'Legal', '01C', '', 1, 'Jocelyn B. Buclig', 'Attorney IV'),
        // (5, 'ICT Unit', 'ICT', '01D', '', 1, 'Rey M. Valenzuela', 'ITO 1'),
        // (6, 'Curriculum and Learning Management Division', 'CLMD', '02', '', 1, 'Viernalyn M. Nama', 'Division Chief'),
        // (7, 'Learning Resource Management and Development', 'LRMD', '02A', '', 1, 'Viernalyn M. Nama', 'Division Chief'),
        // (8, 'Education Support Services Division', 'ESSD', '03', '', 1, 'Eduarda Zapanta', 'Division Chief'),
        // (9, 'Field Technical Assistance Division', 'FTAD', '04', '', 1, 'Michael Girard Alba', 'Division Chief'),
        // (10, 'Quality Assurance Division', 'QAD', '05', '', 1, 'Luz E. Osmeña', 'Division Chief'),
        // (11, 'Human Resource Development Division', 'HRDD', '06', '', 1, 'Jisela Ulpina', 'Division Chief'),
        // (12, 'Policy, Planning and Research Division', 'PPRD', '07', '', 1, 'Elino S. Garcia', 'Division Chief'),
        // (13, 'Administrative Division', 'Admin', '08', '', 1, 'Ann Geralyn T. Pelias', 'CAO'),
        // (14, 'Asset Management Section', 'Asset', '08A', '', 1, 'Michael P. Glorial', 'AO V'),
        // (15, 'Cashier Section', 'Cashier', '08B', '', 1, 'Syril R. Zenarosa', 'AO V'),
        // (16, 'Personnel Section', 'Personnel', '08C', '', 1, 'Maria Susana Oliveros', 'AO V'),
        // (17, 'Records Section', 'Records', '08D', '', 1, 'Babeth C. Cruz', 'AO V'),
        // (18, 'Finance Division', 'Finance', '09', '', 1, 'Marites L. Gloria', 'CAO'),
        // (20, 'Procurement Unit', 'PU', '08E', 'bac.calabarzon@deped.gov.ph', 1, 'Jocelyn L. Martin', 'AO IV'),
        // (21, 'Commission on Audit', 'COA', 'COA', '', 1, NULL, NULL),
        // (22, 'National Educators Academy of the Philippines (NEAP)', 'HRDDNEAP', '06A', NULL, 1, 'Jisela Ulpina', 'Division Chief'),
        // (23, 'Batangas City', 'Batangas City', 'BATS', 'division.batangascity@deped.gov.ph', 2, NULL, NULL),
        // (34, 'Batangas Province', 'Batangas Province', 'BAT', 'deped.batangas@deped.gov.ph', 2, NULL, NULL),
        // (35, 'BiÃƒÂ±an City', 'BiÃƒÂ±an City', 'BIN', 'deped.binancity@deped.gov.ph', 2, NULL, NULL),
        // (36, 'Cabuyao City', 'Cabuyao City', 'CAB', 'division.cabuyao@deped.gov.ph', 2, NULL, NULL),
        // (37, 'Calamba City', 'Calamba City', 'CAL', 'calamba.city@deped.gov.ph', 2, NULL, NULL),
        // (38, 'Cavite City', 'Cavite City', 'CAVS', 'cavite.city@deped.gov.ph', 2, NULL, NULL),
        // (44, 'Cavite Province', 'Cavite Province', 'CAV', 'deped.cavite@deped.gov.ph', 2, NULL, NULL),
        // (45, 'DasmariÃƒÂ±as City', 'DasmariÃƒÂ±as City', 'DAS', 'dasmarinas.city@deped.gov.ph', 2, NULL, NULL),
        // (46, 'General Trias', 'General Trias', 'GEN', 'division.gentri@deped.gov.ph', 2, NULL, NULL),
        // (47, 'Imus City', 'Imus City', 'IMU', 'imus.city@deped.gov.ph', 2, NULL, NULL),
        // (48, 'Laguna', 'Laguna', 'LAG', 'laguna@deped.gov.ph', 2, NULL, NULL),
        // (49, 'Lipa City', 'Lipa City', 'LIP', 'deped.lipacity@deped.gov.ph', 2, NULL, NULL),
        // (50, 'Lucena City', 'Lucena City', 'LUC', 'lucena.city@deped.gov.ph', 2, NULL, NULL),
        // (51, 'Quezon', 'Quezon', 'QUE', 'quezon@deped.gov.ph', 2, NULL, NULL),
        // (52, 'Rizal', 'Rizal', 'RIZ', 'rizal@deped.gov.ph', 2, NULL, NULL),
        // (53, 'San Pablo City', 'San Pablo City', 'SANPAB', 'sanpablo.city@deped.gov.ph', 2, NULL, NULL),
        // (54, 'Sta. Rosa City', 'Sta. Rosa City', 'STAROS', 'santarosa.city@deped.gov.ph', 2, NULL, NULL),
        // (55, 'Tanauan City', 'Tanauan City', 'TAN', 'tanauan.city@deped.gov.ph', 2, NULL, NULL),
        // (56, 'Tayabas City', 'Tayabas City', 'TAY', 'tayabas.city@deped.gov.ph', 2, NULL, NULL),
        // (57, 'Antipolo City', 'Antipolo City', 'ANT', 'antipolo.city@deped.gov.ph', 2, NULL, NULL),
        // (58, 'Bacoor City', 'Bacoor City', 'BAC', 'bacoor.city@deped.gov.ph', 2, NULL, NULL);
    // ");

    DB::statement("INSERT INTO `leave_advance_settings` VALUES (1,'0.002','0.004','0.006','0.008','0.01','0.012','0.015','0.017','0.019','0.021','0.023','0.025','0.027','0.029','0.031','0.033','0.037','0.040','0.042','0.044','0.046','0.048','0.050','0.052','0.054','0.056','0.058','0.060','0.062','0.064','0.065','0.067','0.069','0.071','0.073','0.075','0.077','0.079','0.081','0.083','0.085','0.087','0.090','0.092','0.094','0.096','0.098','0.100','0.102','0.104','0.106','0.108','0.110','0.112','0.115','0.117','0.119','0.121','0.123','0.125','0.125','0.250','0.375','0.500','0.625','0.750','0.875','1.000',NULL,NULL,'1.25','2.50','3.75','5.00','6.25','7.50','8.75','10.00','11.25','12.50','13.75','15.00','0.042','0.083','0.125','0.167','0.208','0.25','0.292','0.333','0.375','0.417','0.458','0.500','0.542','0.583','0.625','0.667','0.708','0.750','0.792','0.833','0.873','0.917','0.958','1.000','1.042','1.083','1.125','1.167','1.208','1.250','2025-08-08 00:20:02','2025-08-08 00:51:14');");
    }
}

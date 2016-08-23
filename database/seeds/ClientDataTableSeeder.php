<?php namespace Sanatorium\Clients\Database\Seeds;

use DB;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ClientDataTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
        $old_data = [
            [1, 'Jan Obadálek', 'Malešická 1871/11', '13000, Praha', 'Czech republic', 'ID: 88927873', 'Not a VAT payer', '2015-08-14 11:06:24', '2015-08-14 15:29:26'],
            [2, 'Luum GmbH', 'Bült 13a', '48143 Münster', 'Germany', 'USt-IdNr. DE 266571403', NULL, '2015-08-14 11:06:24', '2015-08-14 11:06:24'],
            [3, 'Xisio Informationssysteme GmbH', 'Hilpertstraße 3', '64295 Darmstadt', 'Germany', 'Steuernummer: 007 248 50484', '', '2015-08-17 16:40:25', '2015-08-17 16:40:25'],
            [4, 'Team Underscore Ltd', '9 LITTLE PORTLAND STREET', 'OXFORD CIRCUS, LONDON W1W 7JF', '', '07474207', '', '2015-09-03 15:32:08', '2015-09-03 15:32:08'],
            [5, 'EXPOSE Photographers', 'Conny Oelker', 'Schumannstraße 32', '40237 Düsseldorf', '', '', '2015-09-10 11:40:32', '2015-09-10 11:40:32'],
            [6, 'FARMCZSYSTEM, s.r.o.', 'Trojická 1910/7', '128 00 Praha 2', '', 'IČ: 03324966', 'DIČ: CZ03324966', '2015-09-15 13:24:45', '2015-09-15 13:24:45'],
            [7, 'ConQuest entertainment a.s.', 'Praha 1 - Nove Mesto', 'Hybernská 20/1007', '111 21', 'IC 26467909', 'DIC CZ26467909', '2015-09-30 12:39:22', '2015-09-30 12:39:22'],
            [8, 'Felix Hollenstein', 'Colibri Interactive', 'Osterfeldstraße 16', '33605 Bielefeld – Germany', 'Tax number: 83 709 245 189', '', '2015-10-07 15:41:42', '2015-10-07 15:41:42'],
            [9, 'Nicole Ressing', 'Cantadorstrasse 22', '40211 Düsseldorf', '', 'DE 151687141', '', '2015-10-12 12:05:08', '2015-10-12 12:05:08'],
            [10, 'Sleighdogs GmbH', 'Alt-Moabit 19', '105 59 Berlin', 'Germany', 'ID-Nr. HRB151706', 'MwSt.-Nr. DE290944362', '2015-11-10 16:44:52', '2015-11-10 16:44:52'],
            [11, 'Smarttech s.r.o.', 'Urešova 1682/11', 'Praha - Kunratice, 148 00', '', 'IC 24270911', 'DIC CZ24270911', '2015-11-14 14:45:21', '2015-11-14 14:45:21'],
            [12, 'Philipp Condrau', 'Landstrasse 1', '5415 Rieden', 'Schweiz', '', '', '2015-12-04 13:09:39', '2015-12-04 13:09:39'],
            [13, 'Sorsya s.r.o.', '5. Května 1640/65', 'Praha - Vyšehrad', '140 21', 'ICO: 04563671', '', '2015-12-08 14:02:03', '2015-12-08 14:02:03'],
            [14, 'Future Trading s.r.o.', 'sídlem Vojtěšská 211/6', '110 00, Praha - Nové Město', '', 'IČ 04473001', 'DIČ CZ04473001 ', '2016-01-06 11:59:15', '2016-01-06 11:59:15'],
            [15, 'GoodShape, s.r.o.', 'Praha 1 - Staré Město', 'Národní 340/21', 'PSČ 110 00', 'IC: 27897095', 'DIC: CZ27897095', '2016-07-13 13:00:36', '2016-07-13 13:00:36']
        ];


        $clientsRepo = app('Sanatorium\Clients\Repositories\Client\ClientRepositoryInterface');

        foreach( $old_data as $client ) {

            $object = $clientsRepo->firstOrCreate([
                'id' => $client[0],
                'name' => $client[1],
                'tax_id' => $client[5],
                'vat_id' => $client[6],
                'created_at' => $client[7],
                'updated_at' => $client[8],
            ]);

            $object = \Sanatorium\Clients\Models\Client::find($object->id);
            $object->client_address = implode("\n", [$client[2], $client[3], $client[4]]);
            $object->save();

        }

	}

}

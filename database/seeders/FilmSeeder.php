<?php

namespace Database\Seeders;

use App\Models\Film;
use Illuminate\Database\Seeder;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $films = [
            [
                'title' => 'Oppenheimer',
                'description' => 'Oppenheimer adalah kisah epik tentang kehidupan J. Robert Oppenheimer, fisikawan jenius yang memimpin Proyek Manhattan selama Perang Dunia II. Film ini menyajikan pandangan mendalam tentang perjalanan ilmiah dan moral seorang pria yang berjasa menciptakan senjata paling mematikan di dunia. Terperangkap dalam dilema moral, Oppenheimer harus menghadapi konsekuensi dari karyanya saat dunia menyaksikan kehancuran yang disebabkan oleh bom atom. Melalui konflik batin, hubungan pribadi, dan tekanan politik, film ini menelusuri dampak abadi dari penemuannya terhadap sejarah umat manusia.',
                'duration' => 180,
                'producer' => 'Emma Thomas',
                'director' => 'Christopher Nolan',
                'writer' => 'Christopher Nolan',
                'poster' => '/images/posters/Oppenheimer.jpg',
                'trailer' => 'https://youtu.be/uYPbbksJxIg?si=jYPJB6SEcISSGNeo',
                'release_date' => '2024-12-21',
                'end_date' => '2025-01-21',
                'genre_film_id' => [1, 13], // Drama, Biographical
            ],
            [
                'title' => 'Killers of the Flower Moon',
                'description' => 'Berdasarkan kisah nyata, film ini mengisahkan pembunuhan misterius anggota suku Osage di Oklahoma pada tahun 1920-an, yang dikenal sebagai "Reign of Terror". Saat suku yang kaya akan minyak mengalami serangkaian kematian mencurigakan, FBI baru terbentuk dan mengirim agen mereka untuk mengungkap dalang di balik konspirasi yang melibatkan korupsi, keserakahan, dan pengkhianatan. Film ini mengeksplorasi ketegangan budaya antara penduduk asli Amerika dan pengusaha kulit putih yang berusaha mengeksploitasi sumber daya mereka, dipimpin oleh investigasi yang menegangkan dan mengejutkan.',
                'duration' => 206,
                'producer' => 'Martin Scorsese',
                'director' => 'Martin Scorsese',
                'writer' => 'Eric Roth, Martin Scorsese',
                'poster' => '/images/posters/Killers_of_the_Flower_Moon.jpg',
                'trailer' => 'https://youtu.be/EP34Yoxs3FQ?si=e0a8v8ecSogGB2W3',
                'release_date' => '2024-12-30',
                'end_date' => '2024-01-30',
                'genre_film_id' => [1, 12, 17], // Drama, Crime, Mystery
            ],
            [
                'title' => 'The Marvels',
                'description' => 'The Marvels menggabungkan kekuatan Captain Marvel, Ms. Marvel, dan Monica Rambeau dalam sebuah petualangan epik untuk menghadapi ancaman intergalaksi yang dapat menghancurkan alam semesta. Ketika kekuatan mereka tiba-tiba terhubung secara misterius, trio ini harus bersatu untuk mengungkap asal-usul ancaman dan memecahkan konflik yang bisa mengubah keseimbangan galaksi. Film ini penuh dengan aksi intens, visual yang memukau, dan eksplorasi lebih dalam tentang latar belakang para pahlawan super yang saling berbeda, namun memiliki tujuan yang sama dalam melindungi dunia.',
                'duration' => 105,
                'producer' => 'Kevin Feige',
                'director' => 'Nia DaCosta',
                'writer' => 'Megan McDonnell',
                'poster' => '/images/posters/the_marvels.jpeg',
                'trailer' => 'https://youtu.be/wS_qbDztgVY?si=c3p8n9ubY7RcYOWc',
                'release_date' => '2024-12-10',
                'end_date' => '2025-01-10',
                'genre_film_id' => [2, 6, 9], // Action, Sci-Fi, Adventure
            ],
            [
                'title' => 'Dune: Part Two',
                'description' => 'Melanjutkan kisah epik dari novel karya Frank Herbert, "Dune: Part Two" mengikuti perjalanan Paul Atreides saat ia bergabung dengan Chani dan suku Fremen untuk membalas dendam terhadap musuh-musuh yang menghancurkan keluarganya. Dalam pertempuran besar di gurun Arrakis yang tandus, Paul harus menghadapi takdirnya sebagai pemimpin dan "Messiah" yang dinubuatkan oleh rakyat Fremen. Film ini menggali lebih dalam intrik politik, pengkhianatan, dan peperangan yang memperebutkan rempah-rempah berharga, serta bagaimana Paul bergulat dengan takdirnya dan peran besar yang harus ia emban.',
                'duration' => 155,
                'producer' => 'Mary Parent, Denis Villeneuve',
                'director' => 'Denis Villeneuve',
                'writer' => 'Jon Spaihts, Denis Villeneuve',
                'poster' => '/images/posters/dune_part_two.jpg',
                'trailer' => 'https://youtu.be/Way9Dexny3w?si=ifUaZCHhkKJ0rB8F',
                'release_date' => '2024-12-03',
                'end_date' => '2025-01-03',
                'genre_film_id' => [6, 9, 1], // Sci-Fi, Adventure, Drama
            ],
            [
                'title' => 'The Creator',
                'description' => 'Dalam dunia futuristik yang dilanda peperangan antara manusia dan kecerdasan buatan, seorang mantan prajurit diberi misi berbahaya untuk memburu "The Creator", sosok misterius yang menciptakan senjata AI mematikan dengan kekuatan untuk mengakhiri umat manusia. Dengan latar belakang dunia yang penuh kehancuran dan konflik, film ini mengeksplorasi hubungan antara manusia dan teknologi, serta konsekuensi dari ambisi manusia yang berusaha menciptakan sesuatu yang melebihi kendali mereka.',
                'duration' => 133,
                'producer' => 'Gareth Edwards',
                'director' => 'Gareth Edwards',
                'writer' => 'Gareth Edwards, Chris Weitz',
                'poster' => '/images/posters/the_creator.jpg',
                'trailer' => 'https://youtu.be/ex3C1-5Dhb8?si=SckU6hlmbSXt1cKo',
                'release_date' => '2024-12-25',
                'end_date' => '2025-01-25',
                'genre_film_id' => [2, 6], // Action, Sci-Fi
            ],
            [
                'title' => 'The Fabelmans',
                'description' => 'The Fabelmans adalah drama semi-otomatis yang terinspirasi dari masa kecil Steven Spielberg. Film ini mengikuti perjalanan seorang remaja bernama Sammy Fabelman yang menemukan cinta sejatinya terhadap dunia perfilman. Di tengah-tengah tantangan keluarga dan tekanan sosial, Sammy menggunakan kamera untuk mengabadikan momen-momen berharga dan mengatasi trauma emosionalnya. Film ini merupakan penghormatan Spielberg terhadap kekuatan seni dalam membentuk identitas dan mengejar mimpi, sambil menggali dinamika keluarga yang kompleks dan nostalgia masa kecilnya.',
                'duration' => 151,
                'producer' => 'Steven Spielberg, Kristie Macosko Krieger',
                'director' => 'Steven Spielberg',
                'writer' => 'Steven Spielberg, Tony Kushner',
                'poster' => '/images/posters/the_fabelmans.jpg',
                'trailer' => 'https://www.youtube.com/watch?v=D1G2iLSzOe8',
                'release_date' => '2025-01-15',
                'end_date' => '2025-02-15',
                'genre_film_id' => [1, 13], // Drama, Biographical
            ],
            [
                'title' => 'Blue Beetle',
                'description' => 'Blue Beetle mengikuti kisah Jaime Reyes, seorang pemuda biasa yang hidupnya berubah drastis ketika sebuah scarab alien misterius memilihnya sebagai inangnya. Dengan kemampuan baru berupa baju zirah canggih yang memberinya kekuatan luar biasa, Jaime harus belajar untuk mengendalikan kekuatannya dan melawan musuh yang ingin merebut scarab tersebut. Film ini mengeksplorasi tema keluarga, identitas, dan tanggung jawab pahlawan, sambil menampilkan aksi spektakuler dan visual yang memukau.',
                'duration' => 127,
                'producer' => 'John Rickard, Zev Foreman',
                'director' => 'Angel Manuel Soto',
                'writer' => 'Gareth Dunnet-Alcocer',
                'poster' => '/images/posters/blue_beetle.jpg',
                'trailer' => 'https://youtu.be/vS3_72Gb-bI?si=a-oRiJM2TFD0RY4p',
                'release_date' => '2025-01-18',
                'end_date' => '2025-02-18',
                'genre_film_id' => [2, 6, 9], // Action, Sci-Fi, Adventure
            ],            
            
        ];

        foreach ($films as $filmData) {
            $film = Film::create([
                'title' => $filmData['title'],
                'description' => $filmData['description'],
                'duration' => $filmData['duration'],
                'producer' => $filmData['producer'],
                'director' => $filmData['director'],
                'writer' => $filmData['writer'],
                'poster' => $filmData['poster'],
                'trailer' => $filmData['trailer'],
                'release_date' => $filmData['release_date'],
                'end_date' => $filmData['end_date'],
            ]);

            $film->genreFilms()->sync($filmData['genre_film_id']);
        }
    }
}

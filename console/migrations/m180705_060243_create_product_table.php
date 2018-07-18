<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product`.
 */
class m180705_060243_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('product', [
            'id' => $this->primaryKey(),
            'slug' => $this->string()->notNull(),
            'name' => $this->string(64)->notNull(),
            'category' => $this->integer(64)->notNull(),
            'synopsis' => $this->string(),
            'description' => $this->text(),
            'price' => $this->decimal(),
            'price_discount' => $this->decimal(),
            'brand' => $this->integer()->notNull(),
            'discount_flag' => $this->tinyInteger(1)->defaultValue(1),
            'image' => $this->string(),
            'image_path' => $this->string(),
            'image_thumbnail' => $this->string(),
            'image_portrait' => $this->string(),
            'headline' => $this->boolean(),
            'meta_description' => $this->string(),
            'meta_keyword' => $this->string(),
            'product_download_url' => $this->string(),
            'product_download_path' => $this->string(),
            'product_view' => $this->integer(),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(1),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->createTable('product_content', [
            'id' => $this->primaryKey(),
            'product' => $this->integer(),
            'embed_type' => $this->tinyinteger(1)->notNull(),
            'content_type' => $this->tinyinteger(1)->notNull(),
            'content' => $this->string(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->createTable('product_category', [
            'id' => $this->primaryKey(),
            'product' => $this->integer()->notNull(),
            'sub_category' => $this->integer()->notNull(),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(0),
        ]);

        // $this->addPrimaryKey('prod-cate_pk', 'product_category', ['product', 'sub_category']);

        $this->createTable('brand', [
            'id' => $this->primaryKey(),
            'slug' => $this->string()->notNull(),
            'name' => $this->string(),
            'description' => $this->string(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'slug' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'description' => $this->string(),
            'image' => $this->string(),
            'image_path' => $this->string(),
            'image_thumbnail' => $this->string(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->createTable('sub_category', [
            'id' => $this->primaryKey(),
            'category' => $this->integer(),
            'slug' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'description' => $this->string(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->addForeignKey(
            'fk-subcategory-category', 'sub_category', 'category', 'category', 'id', 'CASCADE'
        );
        $this->addForeignKey(
            'fk-product-brand', 'product', 'brand', 'brand', 'id', 'CASCADE'
        );

        $this->addForeignKey(
            'fk-product-category', 'product', 'category', 'category', 'id', 'CASCADE'
        );

        $this->addForeignKey(
            'fk-product-content', 'product_content', 'product', 'product', 'id', 'CASCADE'
        );

        $this->addForeignKey(
            'fk-product-category-product', 'product_category', 'product', 'product', 'id', 'CASCADE'
        );

        $this->addForeignKey(
            'fk-product-sub-category', 'product_category', 'sub_category', 'sub_category', 'id', 'CASCADE'
        );

        $rows = [
            [1, 'marvel', 'Marvel', 'Marvel', 1],
            [2, 'universal-studio', 'Universal Studio', 'Universal Studio Brand', 1],
            [3, 'pixar', 'Pixar', 'Pixar Brand', 1],
        ];

        $this->batchInsert('brand', [
            'id',
            'slug',
            'name',
            'description',
            'status'],
            $rows);

        $rows = [
            [1, 'movie', 'Movie', 'Movie Category', 1],
            [2, 'application', 'Apps', 'Application Category', 1],
            [3, 'music', 'Music', 'Music Category', 1],
        ];

        $this->batchInsert('category', [
            'id',
            'slug',
            'name',
            'description',
            'status'],
            $rows);

        $rows = [
            [1, 'fantasy', 'Fantasy', 'Fantasy Subcategory', 1],
            [1, 'adventure', 'Adventure', 'Adventure Subcategory', 1],
            [1, 'horror', 'Horror', 'Horror Subcategory', 1],
            [2, 'games', 'Games', 'Games Subcategory', 1],
            [2, 'utility', 'Utility', 'Utility Subcategory', 1],
            [2, 'scheduler', 'Scheduler', 'Scheduler Subcategory', 1],
            [3, 'rock', 'Rock', 'Rock Subcategory', 1],
            [3, 'pop', 'Pop', 'Pop Subcategory', 1],
            [3, 'blues', 'Blues', 'Blues Subcategory', 1],
        ];

        $this->batchInsert('sub_category', [
            'category',
            'slug',
            'name',
            'description',
            'status'],
            $rows);

        $rows = [
            [
                1,
                'ant-man-and-the-wasp',
                'Ant-Man and the Wasp',
                1,
                'Pasca kejadian Civil War, Scott Lang (Paul Rudd) kembali bergulat dengan konsekuensi pilihannya sebagai superhero sekaligus sebagai seorang ayah. Saat dia berusaha berjuang untuk menyeimbangkan kembali kehidupannya dirumah dengan tanggungjawabnya sebagai Ant-Man',
                'Pasca kejadian Civil War, Scott Lang (Paul Rudd) kembali bergulat dengan konsekuensi pilihannya sebagai superhero sekaligus sebagai seorang ayah. Saat dia berusaha berjuang untuk menyeimbangkan kembali kehidupannya dirumah dengan tanggungjawabnya sebagai Ant-Man, dia berhadapan dengan Hope van Dyne dan Dr.Hank Pym yang mendesaknya dengan misi baru. Scott kemudian harus belajar bekerjasama dengan Hope dan bertarung bersama dengan Wasp untuk mengungkap sebuah rahasia besar dari masa lalu.',
                300000,
                150000,
                1,
                1,
                'http://res.cloudinary.com/itoktoni/image/upload/v1531885527/tge6duzuzkxzjebpmp1l.jpg',
                'C:/xampp/htdocs/team/uploads/2/ant-man-and-the-wasp.jpg',
                'http://res.cloudinary.com/itoktoni/image/upload/v1531885529/nsern6agzjxblewk90o5.jpg',
                'http://res.cloudinary.com/itoktoni/image/upload/v1531885531/tmwufu3zwstykzwq8vro.jpg',
                1,
                'Pasca kejadian Civil War, Scott Lang (Paul Rudd) kembali bergulat dengan konsekuensi pilihannya sebagai superhero sekaligus sebagai seorang ayah. Saat dia berusaha berjuang untuk menyeimbangkan kembali kehidupannya dirumah dengan tanggungjawabnya sebagai',
                'antman,scott,awaw',
                'http://res.cloudinary.com/itoktoni/image/upload/v1531885533/b9zacdjaw2f0gjrchaae.jpg',
                1,
                '2018-07-18 11:45:26',
                '2018-07-18 11:45:26',
            ],
            [
                2,
                "jurassic-world-fallen-kingdom-2018",
                "Jurassic World: Fallen Kingdom (2018)",
                1,
                "<div>Setelah Isla Nublar porak-poranda akibat letusan gunung berapi, spesies dinosaurus yang tersisa dibawa ke perkebunan Lockwood yang besar, di Amerika.</div></div>",
                "<div><div>Setelah Isla Nublar porak-poranda akibat letusan gunung berapi, spesies dinosaurus yang tersisa dibawa ke perkebunan Lockwood yang besar, di Amerika. Di tempat tersebut, Owen dan Claire menyadari bahwa spesies dinosaurus malah dilelang dan tidak dilestarikan.</div><div>Seekor dinosaurus hibrida yang sangat berbahaya dan dikenal dengan nama Indoraptor, kabur dan mulai meneror penduduk di sekitar perkebunan.,</div><div>dia berhadapan dengan Hope van Dyne dan Dr.Hank Pym yang mendesaknya dengan misi baru. Scott kemudian harus belajar bekerjasama dengan Hope dan bertarung bersama dengan Wasp untuk mengungkap sebuah rahasia besar dari masa lalu.</div></div>",
                250000,
                100000,
                2,
                1,
                "http://res.cloudinary.com/itoktoni/image/upload/v1531900525/l3lroiv3blgilpiu5mjz.jpg",
                "C:/xampp/htdocs/team/uploads/3/jurassic-world-fallen-kingdom-2018.jpg",
                "http://res.cloudinary.com/itoktoni/image/upload/v1531900527/yg1vbm2vj6lgpd84f0p6.jpg",
                "http://res.cloudinary.com/itoktoni/image/upload/v1531900530/i2louiskx1qnckylfkbn.jpg",
                1,
                "Setelah Isla Nublar porak-poranda akibat letusan gunung berapi, spesies dinosaurus yang tersisa dibawa ke perkebunan Lockwood yang besar, di Amerika. Di tempat tersebut, Owen dan Claire menyadari bahwa spesies dinosaurus malah dilelang dan tidak dilestari",
                "jurrasic,park,lah,wes",
                "http://res.cloudinary.com/itoktoni/image/upload/v1531900532/ylgjf0sbnwhfqmox4tlu.jpg",
                1,
                "2018-07-18 15:48:43",
                "2018-07-18 15:48:43",
            ],
            [
                3,
                "single-christ-hart-i-love-you",
                "Single Christ Hart - I Love You",
                3,
                "<p>Ne~ kimi wa naze kanashisou ni utsumuku no? mabushii hodo aoi sora nanoni itsu kara darou kimi to te o tsunai de mo</p>",
                "<p>Ne~ kimi wa naze kanashisou ni utsumuku no? mabushii hodo aoi sora nanoni itsu kara darou kimi to te o tsunai de mo</p>",
                100000,
                50000,
                2,
                1,
                "http://res.cloudinary.com/itoktoni/image/upload/v1531900796/fyahjmdqmpsen3qv91t6.jpg",
                "C:/xampp/htdocs/team/uploads/4/single-christ-hart-i-love-you.jpg",
                "http://res.cloudinary.com/itoktoni/image/upload/v1531900799/vpeeiry7d5n6kra3rh1w.jpg",
                "http://res.cloudinary.com/itoktoni/image/upload/v1531900801/vy366fl6gphyd0imqklt.jpg",
                1,
                "Ne~ kimi wa naze kanashisou ni utsumuku no? mabushii hodo aoi sora nanoni itsu kara darou kimi to te o tsunai de mo",
                "nee,kimi wa,naze",
                "http://res.cloudinary.com/itoktoni/image/upload/v1531900803/ttzwrvi09nwrbxjw52xz.jpg",
                1,
                "2018-07-18 15:59:54",
                "2018-07-18 15:59:54",
            ],
            [
                4,
                "single-christ-hart-home",
                "Single Christ Hart - Home",
                3,
                "<p>Hart was born August 25, 1984 to musician parents in the,&nbsphis parents separated when he was 2.He developed an interest in Japanese music, language.<sup id='cite_ref-offb_1-3' class='reference'></sup></p>",
                "<p>Hart was born August 25, 1984 to musician parents in the&nbsp<a title='San Francisco Bay Area' href='https://en.wikipedia.org/wiki/San_Francisco_Bay_Area'>San Francisco Bay Area</a>, his parents separated when he was 2.<sup id='cite_ref-offb_1-0' class='reference'><a href='https://en.wikipedia.org/wiki/Chris_Hart_(musician)#cite_note-offb-1'>[1]</a></sup>&nbspHe developed an interest in Japanese music, language, and culture beginning age 12 after taking a Japanese class at his school.<sup id='cite_ref-offb_1-1' class='reference'><a href='https://en.wikipedia.org/wiki/Chris_Hart_(musician)#cite_note-offb-1'>[1]</a></sup>&nbspHe was moved by the kindness of the people he met in Japan the next year during his summer vacation.<sup id='cite_ref-offb_1-2' class='reference'><a href='https://en.wikipedia.org/wiki/Chris_Hart_(musician)#cite_note-offb-1'>[1]</a></sup>&nbspHe majored in music and Japanese in college, and took jobs in an airport and with a Japanese cosmetics company to maintain his connection. From his teens until moving to Tokyo, Japan at age 24, Hart performed in Japanese as lead vocalist for the band Nikita w/Metallic Beasts, before starting his own solo rock band, LYV. During his time as LYV, Hart wrote all lyrics and music in Japanese. Upon moving to Japan, Hart took a job working on vending machines. Chris has an older sister and a younger half-brother.<sup id='cite_ref-offb_1-3' class='reference'><a href='https://en.wikipedia.org/wiki/Chris_Hart_(musician)#cite_note-offb-1'>[1]</a></sup></p>",
                250000,
                100000,
                2,
                1,
                "http://res.cloudinary.com/itoktoni/image/upload/v1531901113/jdudktd3csdpsyikpqqx.jpg",
                "C:/xampp/htdocs/team/uploads/5/single-christ-hart-home.jpg",
                "http://res.cloudinary.com/itoktoni/image/upload/v1531901116/ramr6c7s8aprahogaujy.jpg",
                "http://res.cloudinary.com/itoktoni/image/upload/v1531901119/yghimvvy7kpc2pgylovc.jpg",
                1,
                "Hart was born August 25, 1984 to musician parents in the,Â his parents separated when he was 2.He developed an interest in Japanese music, language, and culture beginning age 12 after taking a Japanese class at his school.",
                "christ hart,song,pop",
                "http://res.cloudinary.com/itoktoni/image/upload/v1531901121/cikuxvtkhn59jzas8n78.jpg",
                1,
                "2018-07-18 16:05:11",
                "2018-07-18 16:05:11",
            ],
            [
                5,"consumer-report-v405","Consumer Report v.4.05",2,"<p>Pengertian lain mengatakan bahwa ia adalah sebuah sistem informasi yang terintegrasi yang digunakan untuk merencanakan, menjadwalkan, dan mengendalikan aktivitas-aktivitas prapenjualan dan pascapenjualan dalam sebuah organisasi.</p>","<p>Pengertian lain mengatakan bahwa ia adalah sebuah sistem informasi yang terintegrasi yang digunakan untuk merencanakan, menjadwalkan, dan mengendalikan aktivitas-aktivitas prapenjualan dan pascapenjualan dalam sebuah organisasi.</p>","1000000",NULL,1,0,"http://res.cloudinary.com/itoktoni/image/upload/v1531901278/qgximhkue1cp0r7l4mkf.jpg","C:/xampp/htdocs/team/uploads/6/consumer-report-v405.jpg","http://res.cloudinary.com/itoktoni/image/upload/v1531901280/ciejuqodqhm9wob7bur4.jpg","http://res.cloudinary.com/itoktoni/image/upload/v1531901282/g4huyi94ctjxzqx9crn7.jpg","1","Melalui pengunaan CRM maka perusahaan bisa mendapatkan manfaat untuk penjualan, pemasaran, pelayanan dan juga aktivitas perusahaan lainnya. CRM juga dapat membantu perusahaan untuk berbagi data, memperbaiki hubungan dan dukungan pelanggan, mengurangi biay","crm","http://res.cloudinary.com/itoktoni/image/upload/v1531901285/raulgsmaf0tg9easkq1b.jpg",1,"2018-07-18 16:07:56","2018-07-18 16:07:56"
            ],
        ];

        $this->batchInsert('product', [
            'id',
            'slug',
            'name',
            'category',
            'synopsis',
            'description',
            'price',
            'price_discount',
            'brand',
            'discount_flag',
            'image',
            'image_path',
            'image_thumbnail',
            'image_portrait',
            'headline',
            'meta_description',
            'meta_keyword',
            'product_download_url',
            'status',
            'created_at',
            'updated_at',
        ],
            $rows);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('product_content');
        $this->dropTable('product');
        $this->dropTable('brand');
        $this->dropTable('category');
        $this->dropTable('sub_category');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table 'product'.
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
            'synopsis' => $this->text(),
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
            [4, 'sm-entertainment', 'SM Entertainment', 'SM Entertainment is a South Korean entertainment company established in 1995 by Lee Soo-man. It is currently one of the largest entertainment companies in South Korea.',1]
        ];

        $this->batchInsert('brand', [
            'id',
            'slug',
            'name',
            'description',
            'status'],
            $rows);

        $rows = [
            [1, 'movie', 'Movie', 'Movie Category', 'http://res.cloudinary.com/itoktoni/image/upload/v1531971919/jmfcmdtxkwqwbilujtnl.jpg', 'D:/xampp/htdocs/teamnew/uploads/category/1/movie.jpg', 'http://res.cloudinary.com/itoktoni/image/upload/v1531971921/uvbw5fcdvtdrvl2gy4do.jpg', '2018-07-19 02:27:11', '2018-07-19 02:27:11', 1],
            [2, 'apps', 'Apps', 'Application Category', 'http://res.cloudinary.com/itoktoni/image/upload/v1531971935/vxaf1tqqbzwsdohygnlg.png', 'D:/xampp/htdocs/teamnew/uploads/category/2/apps.png', 'http://res.cloudinary.com/itoktoni/image/upload/v1531971940/iv3ctzgdce6lakatkljs.png', '2018-07-19 02:27:11', '2018-07-19 02:27:11', 1],
            [3, 'music', 'Music', 'Music Category', 'http://res.cloudinary.com/itoktoni/image/upload/v1531971953/cftxehsjm71eyklv0fsu.jpg', 'D:/xampp/htdocs/teamnew/uploads/category/3/music.jpg', 'http://res.cloudinary.com/itoktoni/image/upload/v1531971955/vtbqju6pchrgvpcffbpy.jpg', '2018-07-19 02:27:11', '2018-07-19 02:27:11', 1]
        ];

        $this->batchInsert('category', ['id', 'slug', 'name', 'description', 'image', 'image_path', 'image_thumbnail', 'created_at', 'updated_at', 'status'],
            $rows);

        $rows = [
            [1, 1, 'fantasy', 'Fantasy', 'Fantasy Subcategory', '2018-07-19 02:27:11', '2018-07-19 02:27:11', 1],
            [2, 1, 'adventure', 'Adventure', 'Adventure Subcategory', '2018-07-19 02:27:11', '2018-07-19 02:27:11', 1],
            [3, 1, 'horror', 'Horror', 'Horror Subcategory', '2018-07-19 02:27:11', '2018-07-19 02:27:11', 1],
            [4, 2, 'games', 'Games', 'Games Subcategory', '2018-07-19 02:27:11', '2018-07-19 02:27:11', 1],
            [5, 2, 'utility', 'Utility', 'Utility Subcategory', '2018-07-19 02:27:11', '2018-07-19 02:27:11', 1],
            [6, 2, 'scheduler', 'Scheduler', 'Scheduler Subcategory', '2018-07-19 02:27:11', '2018-07-19 02:27:11', 1],
            [7, 3, 'rock', 'Rock', 'Rock Subcategory', '2018-07-19 02:27:11', '2018-07-19 02:27:11', 1],
            [8, 3, 'pop', 'Pop', 'Pop Subcategory', '2018-07-19 02:27:11', '2018-07-19 02:27:11', 1],
            [9, 3, 'blues', 'Blues', 'Blues Subcategory', '2018-07-19 02:27:11', '2018-07-19 02:27:11', 1],
            [10, 3, 'edm', 'EDM', 'Electronic dance music', '2018-07-19 03:56:45', '2018-07-19 03:56:45', 1],
            [11, 3, 'rb', 'R&B', 'Contemporary R&B', '2018-07-19 03:57:35', '2018-07-19 03:57:35', 1],
            [12, 3, 'bubblegum-pop', 'Bubblegum Pop', 'Genre of pop music with an upbeat sound contrived and marketed to appeal to pre-teens and teenagers', '2018-07-19 07:25:45', '2018-07-19 07:25:45', 1],
            [13, 3, 'nu-disco', 'Nu-disco', 'Nu-disco, sometimes called disco house, which can also refer to funky house and to a style of French house', '2018-07-19 07:27:16', '2018-07-19 07:27:16', 1],
            [14, 3, 'electropop', 'Electropop', 'Electropop is a variant of synth-pop that places more emphasis on a harder, electronic sound.', '2018-07-19 07:52:23', '2018-07-19 07:52:23', 1],
            [15, 3, 'hip-hop', 'Hip Hop', 'Music genre developed in the United States by inner-city African Americans in the 1970s which consists of a stylized rhythmic music that commonly accompanies rapping, a rhythmic and rhyming speech that is chanted.', '2018-07-19 07:55:20', '2018-07-19 07:55:20', 1],
            [16, 1, 'superhero', 'Superhero', 'Superhero Movies', '2018-07-19 08:04:36', '2018-07-19 08:04:36', 1],
            [17, 1, 'sci-fi', 'Sci-Fi', 'Sci-Fi Movies', '2018-07-19 08:05:00', '2018-07-19 08:05:00', 1]
        ];

        $this->batchInsert('sub_category', ['id', 'category', 'slug', 'name', 'description', 'created_at', 'updated_at', 'status'],
            $rows);

        $rows = [
            [1, 'ant-man-and-the-wasp', 'Ant-Man and the Wasp', 1, '<p>Scott Lang is grappling with the consequences of his choices as both a superhero and a father. Approached by Hope van Dyne and Dr. Hank Pym, Lang must once again don the Ant-Man suit and fight alongside the Wasp.&nbsp;</p>', '<p>Ant-Man and the Wasp&nbsp;is a 2018 American&nbsp;superhero film&nbsp;based on the&nbsp;Marvel Comics&nbsp;characters&nbsp;Scott Lang / Ant-Man&nbsp;and&nbsp;Hope van Dyne / Wasp. Produced by&nbsp;Marvel Studios&nbsp;and distributed by&nbsp;Walt Disney Studios Motion Pictures, it is the sequel to 2015\'s&nbsp;Ant-Man, and&nbsp;the twentieth film&nbsp;in the&nbsp;Marvel Cinematic Universe&nbsp;(MCU). The film is directed by&nbsp;Peyton Reed&nbsp;and written by the writing teams of&nbsp;Chris McKenna&nbsp;and Erik Sommers, and&nbsp;Paul Rudd, Andrew Barrer, and Gabriel Ferrari. It stars Rudd as Lang and&nbsp;Evangeline Lilly&nbsp;as Van Dyne, alongside&nbsp;Michael Pe&ntilde;a,&nbsp;Walton Goggins,&nbsp;Bobby Cannavale,&nbsp;Judy Greer,&nbsp;Tip \"T.I.\" Harris,&nbsp;David Dastmalchian,&nbsp;Hannah John-Kamen,&nbsp;Abby Ryder Fortson,&nbsp;Randall Park,&nbsp;Michelle Pfeiffer,&nbsp;Laurence Fishburne, and&nbsp;Michael Douglas. In&nbsp;Ant-Man and the Wasp, the titular pair work with&nbsp;Hank Pym&nbsp;to retrieve&nbsp;Janet van Dyne&nbsp;from the&nbsp;quantum realm.</p>', '300000', '150000', 1, 1, 'http://res.cloudinary.com/itoktoni/image/upload/v1531987534/fo4tpd8ot2gg6et2ct06.jpg', 'D:/xampp/htdocs/teamnew/uploads/1/ant-man-and-the-wasp.jpg', 'http://res.cloudinary.com/itoktoni/image/upload/v1531987536/vykffrehjaqebcldwc0b.jpg', 'http://res.cloudinary.com/itoktoni/image/upload/v1531987538/tf645gg71ztsi6u2nguw.jpg', 1, 'Scott Lang is grappling with the consequences of his choices as both a superhero and a father. Approached by Hope van Dyne and Dr. Hank Pym, Lang must once again don the Ant-Man suit and fight alongside the Wasp. ', 'antman,scott,awaw', 'http://res.cloudinary.com/itoktoni/image/upload/v1531885533/b9zacdjaw2f0gjrchaae.jpg', NULL, NULL, 1, '2018-07-18 03:45:26', '2018-07-18 03:45:26'],
            [2, 'jurassic-world-fallen-kingdom-2018', 'Jurassic World: Fallen Kingdom (2018)', 1, '<p>Three years after the destruction of the Jurassic World theme park, Owen Grady and Claire Dearing return to the island of Isla Nublar to save the remaining dinosaurs from a volcano that\'s about to erupt.</p>', '<p>Jurassic World: Fallen Kingdom is a 2018 American science fiction adventure film and the sequel to Jurassic World (2015). Directed by J. A. Bayona, it is the fifth installment of the Jurassic Park film series, as well as the second installment of a planned Jurassic World trilogy. Derek Connolly and Jurassic World director Colin Trevorrow both returned as writers, with Trevorrow and original Jurassic Park director Steven Spielberg acting as executive producers. It was released in theaters, Real D 3D, IMAX and IMAX 3D.</p>\r\n<p>Set on the fictional Central American island of Isla Nublar, off the Pacific coast of Costa Rica, it follows Owen Grady and Claire Dearing as they rescue the remaining dinosaurs on the island before a volcanic eruption destroys it. Chris Pratt, Bryce Dallas Howard, B. D. Wong, and Jeff Goldblum reprise their roles from previous films in the series, with Rafe Spall, Justice Smith, Daniella Pineda, James Cromwell, Toby Jones, Ted Levine, Isabella Sermon, and Geraldine Chaplin joining the cast.</p>\r\n<p>Filming took place from February to July 2017 in the United Kingdom and Hawaii. Produced and distributed by Universal Pictures, Fallen Kingdom premiered in Madrid on May 21, 2018, and was released in the United States on June 22, 2018. The film has grossed over $1.1 billion worldwide, making it the third Jurassic film to pass the mark, the third highest-grossing film of 2018 and the 18th highest-grossing film of all time. It received mixed reviews from critics, who praised Pratt\'s performance, Bayona\'s direction, its visuals, and the \"surprisingly dark moments\", although many criticized the screenplay and felt the film added nothing new to the franchise, with some suggesting it had run its course.[8] An untitled sequel is set to be released on June 11, 2021, with Trevorrow returning to direct.</p>', '250000', '100000', 2, 1, 'http://res.cloudinary.com/itoktoni/image/upload/v1531987786/lyzs7f2oweuvrspkjd7i.jpg', 'D:/xampp/htdocs/teamnew/uploads/2/jurassic-world-fallen-kingdom-2018.jpg', 'http://res.cloudinary.com/itoktoni/image/upload/v1531987788/xphkk2gmxdkvqhldvhzs.jpg', 'http://res.cloudinary.com/itoktoni/image/upload/v1531987790/utvlp4jg7qvcgsy3xfgs.jpg', 1, 'Three years after the destruction of the Jurassic World theme park, Owen Grady and Claire Dearing return to the island of Isla Nublar to save the remaining dinosaurs from a volcano that\'s about to erupt.', 'jurrasic,park,lah,wes', 'http://res.cloudinary.com/itoktoni/image/upload/v1531900532/ylgjf0sbnwhfqmox4tlu.jpg', NULL, NULL, 1, '2018-07-18 07:48:43', '2018-07-18 07:48:43'],
            [3, 'single-christ-hart-i-love-you', 'Single Christ Hart - I Love You', 3, '<p>Ne~ kimi wa naze kanashisou ni utsumuku no? mabushii hodo aoi sora nanoni itsu kara darou kimi to te o tsunai de mo</p>', '<p>Ne~ kimi wa naze kanashisou ni utsumuku no? mabushii hodo aoi sora nanoni itsu kara darou kimi to te o tsunai de mo</p>', '100000', '50000', 2, 1, 'http://res.cloudinary.com/itoktoni/image/upload/v1531900796/fyahjmdqmpsen3qv91t6.jpg', 'C:/xampp/htdocs/team/uploads/4/single-christ-hart-i-love-you.jpg', 'http://res.cloudinary.com/itoktoni/image/upload/v1531900799/vpeeiry7d5n6kra3rh1w.jpg', 'http://res.cloudinary.com/itoktoni/image/upload/v1531900801/vy366fl6gphyd0imqklt.jpg', 1, 'Ne~ kimi wa naze kanashisou ni utsumuku no? mabushii hodo aoi sora nanoni itsu kara darou kimi to te o tsunai de mo', 'nee,kimi wa,naze', 'http://res.cloudinary.com/itoktoni/image/upload/v1531900803/ttzwrvi09nwrbxjw52xz.jpg', NULL, NULL, 1, '2018-07-18 07:59:54', '2018-07-18 07:59:54'],
            [4, 'single-christ-hart-home', 'Single Christ Hart - Home', 3, '<p>Hart was born August 25, 1984 to musician parents in the,&nbsphis parents separated when he was 2.He developed an interest in Japanese music, language.<sup id=\'cite_ref-offb_1-3\' class=\'reference\'></sup></p>', '<p>Hart was born August 25, 1984 to musician parents in the&nbsp<a title=\'San Francisco Bay Area\' href=\'https://en.wikipedia.org/wiki/San_Francisco_Bay_Area\'>San Francisco Bay Area</a>, his parents separated when he was 2.<sup id=\'cite_ref-offb_1-0\' class=\'reference\'><a href=\'https://en.wikipedia.org/wiki/Chris_Hart_(musician)#cite_note-offb-1\'>[1]</a></sup>&nbspHe developed an interest in Japanese music, language, and culture beginning age 12 after taking a Japanese class at his school.<sup id=\'cite_ref-offb_1-1\' class=\'reference\'><a href=\'https://en.wikipedia.org/wiki/Chris_Hart_(musician)#cite_note-offb-1\'>[1]</a></sup>&nbspHe was moved by the kindness of the people he met in Japan the next year during his summer vacation.<sup id=\'cite_ref-offb_1-2\' class=\'reference\'><a href=\'https://en.wikipedia.org/wiki/Chris_Hart_(musician)#cite_note-offb-1\'>[1]</a></sup>&nbspHe majored in music and Japanese in college, and took jobs in an airport and with a Japanese cosmetics company to maintain his connection. From his teens until moving to Tokyo, Japan at age 24, Hart performed in Japanese as lead vocalist for the band Nikita w/Metallic Beasts, before starting his own solo rock band, LYV. During his time as LYV, Hart wrote all lyrics and music in Japanese. Upon moving to Japan, Hart took a job working on vending machines. Chris has an older sister and a younger half-brother.<sup id=\'cite_ref-offb_1-3\' class=\'reference\'><a href=\'https://en.wikipedia.org/wiki/Chris_Hart_(musician)#cite_note-offb-1\'>[1]</a></sup></p>', '250000', '100000', 2, 1, 'http://res.cloudinary.com/itoktoni/image/upload/v1531901113/jdudktd3csdpsyikpqqx.jpg', 'C:/xampp/htdocs/team/uploads/5/single-christ-hart-home.jpg', 'http://res.cloudinary.com/itoktoni/image/upload/v1531901116/ramr6c7s8aprahogaujy.jpg', 'http://res.cloudinary.com/itoktoni/image/upload/v1531901119/yghimvvy7kpc2pgylovc.jpg', 1, 'Hart was born August 25, 1984 to musician parents in the,Â his parents separated when he was 2.He developed an interest in Japanese music, language, and culture beginning age 12 after taking a Japanese class at his school.', 'christ hart,song,pop', 'http://res.cloudinary.com/itoktoni/image/upload/v1531901121/cikuxvtkhn59jzas8n78.jpg', NULL, NULL, 1, '2018-07-18 08:05:11', '2018-07-18 08:05:11'],
            [5, 'consumer-report-v405', 'Consumer Report v.4.05', 2, '<p>Pengertian lain mengatakan bahwa ia adalah sebuah sistem informasi yang terintegrasi yang digunakan untuk merencanakan, menjadwalkan, dan mengendalikan aktivitas-aktivitas prapenjualan dan pascapenjualan dalam sebuah organisasi.</p>', '<p>Pengertian lain mengatakan bahwa ia adalah sebuah sistem informasi yang terintegrasi yang digunakan untuk merencanakan, menjadwalkan, dan mengendalikan aktivitas-aktivitas prapenjualan dan pascapenjualan dalam sebuah organisasi.</p>', '1000000', NULL, 1, 0, 'http://res.cloudinary.com/itoktoni/image/upload/v1531901278/qgximhkue1cp0r7l4mkf.jpg', 'C:/xampp/htdocs/team/uploads/6/consumer-report-v405.jpg', 'http://res.cloudinary.com/itoktoni/image/upload/v1531901280/ciejuqodqhm9wob7bur4.jpg', 'http://res.cloudinary.com/itoktoni/image/upload/v1531901282/g4huyi94ctjxzqx9crn7.jpg', 1, 'Melalui pengunaan CRM maka perusahaan bisa mendapatkan manfaat untuk penjualan, pemasaran, pelayanan dan juga aktivitas perusahaan lainnya. CRM juga dapat membantu perusahaan untuk berbagi data, memperbaiki hubungan dan dukungan pelanggan, mengurangi biay', 'crm', 'http://res.cloudinary.com/itoktoni/image/upload/v1531901285/raulgsmaf0tg9easkq1b.jpg', NULL, NULL, 1, '2018-07-18 08:07:56', '2018-07-18 08:07:56'],
            [6, 'holiday', 'Holiday', 3, '<p>Holiday Night is the sixth Korean-language studio album and ninth overall by South Korean girl group Girls\' Generation. It was released digitally on August 4 and physically on August 7, 2017 by S.M. Entertainment.</p>', '', '100000', '500', 4, 1, 'http://res.cloudinary.com/mitrais/image/upload/v1531442791/uuziwpdunvp9bigdhjsf.jpg', 'D:/xampp/htdocs/teamnew/uploads/1/holiday.jpg', 'http://res.cloudinary.com/mitrais/image/upload/v1531442793/lx6o9vvxxakjxtpmgrcp.jpg', 'http://res.cloudinary.com/mitrais/image/upload/v1531442795/iptbjln45r6flkiexk9r.jpg', 1, '', '', '', NULL, NULL, 1, '2018-07-12 16:46:27', '2018-07-12 16:46:27'],
            [7, 'all-night', 'All Night', 3, '<p>\"All Night\" is a song recorded by South Korean girl group Girls\' Generation for their sixth studio album Holiday Night (2017). The song was released digitally on August 4, 2017 as the album\'s single alongside \"Holiday\" by S.M. Entertainment.</p>', '', '100000', NULL, 4, 0, 'http://res.cloudinary.com/mitrais/image/upload/v1531443066/ysspvvwowtnzjsjqz8ho.jpg', 'D:/xampp/htdocs/teamnew/uploads/2/all-night.jpg', 'http://res.cloudinary.com/mitrais/image/upload/v1531443068/xsrwzuvpqhtgaz4xmsx1.jpg', 'http://res.cloudinary.com/mitrais/image/upload/v1531443071/qkpjqrhi6b0a1kczracl.jpg', 1, '', '', '', NULL, NULL, 1, '2018-07-12 16:51:04', '2018-07-12 16:51:04'],
            [8, 'catch-me-if-you-can', 'Catch Me If You Can', 3, '<p>\"Catch Me If You Can\" is a song recorded in two languages (Japanese and Korean) by South Korean girl group Girls\' Generation. The Korean version was released by S.M. Entertainment and KT Music on April 10, 2015.</p>', '', '100000', NULL, 4, 0, 'http://res.cloudinary.com/mitrais/image/upload/v1531443279/fzm0rf8fchqrjmyhs4xk.jpg', 'D:/xampp/htdocs/teamnew/uploads/3/catch-me-if-you-can.jpg', 'http://res.cloudinary.com/mitrais/image/upload/v1531443281/ksegpyyhr8kqxiyqc03y.jpg', 'http://res.cloudinary.com/mitrais/image/upload/v1531443283/sscjkgjsgg6mg8h0mjgm.jpg', 1, '', '', '', NULL, NULL, 1, '2018-07-12 16:54:33', '2018-07-12 16:54:33'],
            [9, 'lion-heart', 'Lion Heart', 3, '<p>Lion Heart is the fifth Korean language studio album recorded by South Korean girl group Girls\' Generation. It marked their first record as an eight-member group since the departure of member Jessica in September 2014.&nbsp;</p>', '', '100000', NULL, 4, 0, 'http://res.cloudinary.com/mitrais/image/upload/v1531443361/lmpycx8vaoyzqy29wzxb.jpg', 'D:/xampp/htdocs/teamnew/uploads/4/lion-heart.jpg', 'http://res.cloudinary.com/mitrais/image/upload/v1531443363/c35sttopozlgo3mwtdkn.jpg', 'http://res.cloudinary.com/mitrais/image/upload/v1531443365/lzgvzcpew6m1zprvemoj.jpg', 1, '', '', '', NULL, NULL, 1, '2018-07-12 16:55:59', '2018-07-12 16:55:59'],
            [10, 'party', 'Party', 3, '<p>\"Party\" (stylized as PARTY) is a song recorded by South Korean girl group Girls\' Generation for their fifth Korean studio album Lion Heart (2015). It was released as the lead single from the album by S.M. Entertainment on July 7, 2015</p>', '', '100000', NULL, 4, 0, 'http://res.cloudinary.com/mitrais/image/upload/v1531443472/davn47a4jhlei5e5mwzt.jpg', 'D:/xampp/htdocs/teamnew/uploads/5/party.jpg', 'http://res.cloudinary.com/mitrais/image/upload/v1531443474/lhs9tzti08qhd3q4hjzq.jpg', 'http://res.cloudinary.com/mitrais/image/upload/v1531443477/cdjhqj3a0qtkvkonapmb.jpg', 1, '', '', '', NULL, NULL, 1, '2018-07-12 16:57:50', '2018-07-12 16:57:50'],
            [11, 'you-think', 'You Think', 3, '<p>\"You Think\" is a song performed by South Korean girl group Girls\' Generation. It was released on August 19, 2015 as the third single from the group\'s fifth studio album Lion Heart by S.M. Entertainment.</p>', '', '100000', NULL, 4, 0, 'http://res.cloudinary.com/mitrais/image/upload/v1531443570/tinz1zmusl5l7kwoopcm.jpg', 'D:/xampp/htdocs/teamnew/uploads/6/you-think.jpg', 'http://res.cloudinary.com/mitrais/image/upload/v1531443572/p19h6e52q6h7bdj5lgd2.jpg', 'http://res.cloudinary.com/mitrais/image/upload/v1531443574/n6xb2uwvp8ou1fjkosbb.jpg', 1, '', '', '', NULL, NULL, 1, '2018-07-12 16:59:27', '2018-07-12 16:59:27'],
            [12, 'dancing-queen', 'Dancing Queen', 3, '<p>\"Dancing Queen\" is a Korean song by South Korean girl group Girls\' Generation. It was released on December 21, 2012 as the lead single from their fourth Korean studio album, I Got a Boy (2013).</p>', '', '120000', NULL, 4, 0, 'http://res.cloudinary.com/mitrais/image/upload/v1531443853/gpt7bcbud4krfqsovuxv.png', 'D:/xampp/htdocs/teamnew/uploads/7/dancing-queen.png', 'http://res.cloudinary.com/mitrais/image/upload/v1531443856/jglla3u05oelolwoybp6.png', 'http://res.cloudinary.com/mitrais/image/upload/v1531443858/ty8u7naticogat4fibml.png', 1, '', '', '', NULL, NULL, 1, '2018-07-12 17:04:08', '2018-07-12 17:04:08'],
            [13, 'mrmr', 'Mr.Mr.', 3, '<p>Mr.Mr. is the fourth extended play (EP) by South Korean girl group Girls\' Generation. The EP consists of six tracks and it incorporates electropop and R&amp;B-pop music genres.</p>', '', '120000', NULL, 4, 0, 'http://res.cloudinary.com/mitrais/image/upload/v1531444040/pyz1yi5quiuykn1cratq.jpg', 'D:/xampp/htdocs/teamnew/uploads/8/mrmr.jpg', 'http://res.cloudinary.com/mitrais/image/upload/v1531444043/bx1vzcoare9nsd8tzrub.jpg', 'http://res.cloudinary.com/mitrais/image/upload/v1531444045/foiyyb0dzvieithhzfqi.jpg', 1, '', '', '', NULL, NULL, 1, '2018-07-12 17:07:18', '2018-07-12 17:07:18']
        ];

        $this->batchInsert('product', ['id', 'slug', 'name', 'category', 'synopsis', 'description', 'price', 'price_discount', 'brand', 'discount_flag', 'image', 'image_path', 'image_thumbnail', 'image_portrait', 'headline', 'meta_description', 'meta_keyword', 'product_download_url', 'product_download_path', 'product_view', 'status', 'created_at', 'updated_at'],
            $rows);


        $rows = [
            [1, 6, 8, 1],
            [2, 7, 12, 0],
            [3, 7, 13, 0],
            [4, 8, 10, 0],
            [5, 9, 12, 0],
            [6, 9, 14, 0],
            [7, 10, 12, 0],
            [8, 10, 14, 0],
            [9, 11, 14, 0],
            [10, 11, 15, 0],
            [11, 12, 8, 0],
            [12, 13, 11, 0],
            [13, 13, 14, 0],
            [14, 1, 1, 1],
            [15, 1, 2, 1],
            [16, 1, 16, 1],
            [17, 2, 1, 1],
            [18, 2, 2, 1],
            [19, 2, 17, 1]
        ];


        $this->batchInsert('product_category', ['id', 'product', 'sub_category', 'status'],
            $rows);

        $rows = [
                [1, 6, 1, 1, '%20%3Ciframe%20width=%22560%22%20height=%22315%22%20src=%22https://www.youtube.com/embed/YwN-CN9EjTg%22%20frameborder=%220%22%20allow=%22autoplay;%20encrypted-media%22%20allowfullscreen%3E%3C/iframe%3E', '2018-07-19 07:21:41', '2018-07-19 07:21:41', 1],
                    [2, 7, 1, 1, '%20%3Ciframe%20width=%22560%22%20height=%22315%22%20src=%22https://www.youtube.com/embed/f4w8IbQTJpY%22%20frameborder=%220%22%20allow=%22autoplay;%20encrypted-media%22%20allowfullscreen%3E%3C/iframe%3E', '2018-07-19 07:28:33', '2018-07-19 07:28:33', 1],
                    [3, 8, 1, 1, '%20%3Ciframe%20width=%22560%22%20height=%22315%22%20src=%22https://www.youtube.com/embed/b09U0KLv6I4%22%20frameborder=%220%22%20allow=%22autoplay;%20encrypted-media%22%20allowfullscreen%3E%3C/iframe%3E', '2018-07-19 07:50:50', '2018-07-19 07:50:50', 1],
                    [4, 9, 1, 1, '%20%3Ciframe%20width=%22560%22%20height=%22315%22%20src=%22https://www.youtube.com/embed/nVCubhQ454c%22%20frameborder=%220%22%20allow=%22autoplay;%20encrypted-media%22%20allowfullscreen%3E%3C/iframe%3E', '2018-07-19 07:53:25', '2018-07-19 07:53:25', 1],
                    [5, 10, 1, 1, '%20%3Ciframe%20width=%22560%22%20height=%22315%22%20src=%22https://www.youtube.com/embed/HQzu7NYlZNQ%22%20frameborder=%220%22%20allow=%22autoplay;%20encrypted-media%22%20allowfullscreen%3E%3C/iframe%3E', '2018-07-19 07:54:14', '2018-07-19 07:54:14', 1],
                    [6, 11, 1, 1, '%20%3Ciframe%20width=%22560%22%20height=%22315%22%20src=%22https://www.youtube.com/embed/hJYGddE0vHc%22%20frameborder=%220%22%20allow=%22autoplay;%20encrypted-media%22%20allowfullscreen%3E%3C/iframe%3E', '2018-07-19 07:56:08', '2018-07-19 07:56:08', 1],
                    [7, 12, 1, 1, '%20%3Ciframe%20width=%22560%22%20height=%22315%22%20src=%22https://www.youtube.com/embed/EXZxc8GSXnI%22%20frameborder=%220%22%20allow=%22autoplay;%20encrypted-media%22%20allowfullscreen%3E%3C/iframe%3E', '2018-07-19 07:56:51', '2018-07-19 07:56:51', 1],
                    [8, 13, 1, 1, '%20%3Ciframe%20width=%22560%22%20height=%22315%22%20src=%22https://www.youtube.com/embed/Z8j_XEn9b_8%22%20frameborder=%220%22%20allow=%22autoplay;%20encrypted-media%22%20allowfullscreen%3E%3C/iframe%3E', '2018-07-19 07:57:40', '2018-07-19 07:57:40', 1],
                    [9, 1, 1, 1, '%3Ciframe%20width=%22560%22%20height=%22315%22%20src=%22https://www.youtube.com/embed/UUkn-enk2RU%22%20frameborder=%220%22%20allow=%22autoplay;%20encrypted-media%22%20allowfullscreen%3E%3C/iframe%3E', '2018-07-19 08:07:33', '2018-07-19 08:07:33', 1],
                    [10, 1, 1, 1, '%20%3Ciframe%20width=%22560%22%20height=%22315%22%20src=%22https://www.youtube.com/embed/8_rTIAOohas%22%20frameborder=%220%22%20allow=%22autoplay;%20encrypted-media%22%20allowfullscreen%3E%3C/iframe%3E', '2018-07-19 08:07:33', '2018-07-19 08:07:33', 1],
                    [11, 2, 1, 1, '%20%3Ciframe%20width=%22560%22%20height=%22315%22%20src=%22https://www.youtube.com/embed/vn9mMeWcgoM%22%20frameborder=%220%22%20allow=%22autoplay;%20encrypted-media%22%20allowfullscreen%3E%3C/iframe%3E', '2018-07-19 08:09:38', '2018-07-19 08:09:38', 1]
            ];

        $this->batchInsert('product_content', ['id', 'product', 'embed_type', 'content_type', 'content', 'created_at', 'updated_at', 'status'],
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

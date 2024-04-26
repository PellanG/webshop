<?php
require_once ('models/Product.php');
require_once ('models/UserDatabase.php');
require_once ('models/Category.php');



class DBContext
{

    private $pdo;
    private $usersDatabase;

    function getUsersDatabase()
    {
        return $this->usersDatabase;
    }

    function __construct()
    {
        $host = $_ENV['host'];
        $db = $_ENV['db'];
        $user = $_ENV['user'];
        $pass = $_ENV['pass'];
        $dsn = "mysql:host=$host;dbname=$db";
        $this->pdo = new PDO($dsn, $user, $pass);
        $this->usersDatabase = new UserDatabase($this->pdo);
        $this->initIfNotInitialized();
        $this->seedfNotSeeded();

    }

    function getAllCategories()
    {
        return $this->pdo->query("SELECT * FROM category")->fetchAll(PDO::FETCH_CLASS, 'Category');

    }
    function searchProduct($sortCol, $sortOrder, $q, $categoryId, $pageNo = 1, $pageSize = 20)
    {
        if ($sortCol == null) {
            $sortCol = "Id";
        }
        if ($sortOrder == null) {
            $sortOrder = "asc";
        }
        $sql = "SELECT * FROM products ";
        $paramsArray = [];
        $addedWhere = false;
        if ($q != null && strlen($q) > 0) {
            if (!$addedWhere) {
                $sql = $sql . " WHERE ";
                $addedWhere = true;
            } else {
                $sql = $sql . " AND ";
            }
            $sql = $sql . " ( categoryId like :q";
            $sql = $sql . " OR  price like :q";
            $sql = $sql . " OR  stockLevel like :q";
            $sql = $sql . " OR  title like :q )";
            $paramsArray["q"] = '%' . $q . '%';
        }

        if ($categoryId != null && strlen($categoryId) > 0) {
            if (!$addedWhere) {
                $sql = $sql . " WHERE ";
                $addedWhere = true;
            } else {
                $sql = $sql . " AND ";
            }

            $sql = $sql . " ( CategoryId = :categoryId )";
            $paramsArray["categoryId"] = $categoryId;
        }


        $sql .= " ORDER BY $sortCol $sortOrder ";

        $sqlCount = str_replace("SELECT * FROM", "SELECT CEIL (COUNT(*)/$pageSize)FROM", $sql);

        $offset = ($pageNo - 1) * $pageSize;
        $sql .= "limit $offset, $pageSize";

        $prep = $this->pdo->prepare($sql);
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Product');
        $prep->execute($paramsArray);
        $data = $prep->fetchAll();

        $prep2 = $this->pdo->prepare($sqlCount);
        $prep2->execute($paramsArray);

        $num_pages = $prep2->fetchColumn();

        $arr = ["data" => $data, "num_pages" => $num_pages];

        return $arr;
    }



    function getAllProducts($sortCol, $sortOrder, $q, $categoryId)
    {
        if ($sortCol == null) {
            $sortCol = "Id";
        }
        if ($sortOrder == null) {
            $sortOrder = "asc";
        }

        return $this->pdo->query("SELECT * FROM products ORDER BY $sortCol $sortOrder")->fetchAll(PDO::FETCH_CLASS, 'Product');
    }
    function getProduct($id)
    {
        $prep = $this->pdo->prepare('SELECT * FROM products where id=:id');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Product');
        $prep->execute(['id' => $id]);
        return $prep->fetch();
    }
    function getProductByTitle($title)
    {
        $prep = $this->pdo->prepare('SELECT * FROM products where title=:title');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Product');
        $prep->execute(['title' => $title]);
        return $prep->fetch();
    }

    function getCategoryByTitle($title): Category|false
    {
        $prep = $this->pdo->prepare("SELECT * FROM category where title=:title");
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Category');
        $prep->execute(['title' => $title]);
        return $prep->fetch();
    }
    function getCategory($id): Category|false
    {
        $prep = $this->pdo->prepare("SELECT * FROM category where id=:id");
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Category');
        $prep->execute(['id' => $id]);
        return $prep->fetch();
    }
    function getPopularProducts($sortCol, $sortOrder, $q, $categoryId)
    {

        return $this->pdo->query('select * from products order by popularity desc limit 0,10')->fetchAll(PDO::FETCH_CLASS, 'Product');

    }


    function seedfNotSeeded()
    {
        static $seeded = false;
        if ($seeded)
            return;



        $this->createIfNotExisting('Granatäpple', 18, 39, 'Bär & Frukt', 'Planta av Punica granatum i 8 cm', 'pomegranade.jpeg', 'Ett trevligt litet träd som tål några minusgrader. Blommar med vackra, röda blommor. Om frukterna ska hinna mogna krävs antingen en mycket varm och lång sommar, eller odling i växthus eller uterum.', 3);
        $this->createIfNotExisting("Nektarin 'Necta Me'", 189, 17, 'Bär & Frukt', 'Prunus persica var. nucipersica - Jumboplugg', 'nectarin.jpeg', "'Necta Me' får stora röda frukter med ovanligt söt och saftig smak. Den får rosavita blommor i maj och frukterna mognar i slutet av juli. Förvara den frostfritt och ljust under vintermånaderna. Den kan växa på friland i de södra delarna av landet i skyddat läge och bör täckas på vintern. Sorten är självfertil. Trivs i en näringsrik, kalkrik, mullrik jord.", 2);
        $this->createIfNotExisting("Persika 'Peach Me Donut'", 189, 13, 'Bär & Frukt', "'Prunus persica 'Peach Me Donut' - Jumboplugg'", 'peach.jpeg', "'Peach Me Donut' ger stora platta orangeröd frukter med krispigt och saftigt fruktkött med mycket söt smak. Den får rosavita blommor i maj och frukterna mognar juli-september. Kan övervintra på friland i skyddat läge i södra sverige. Annars rekommenderas odling i växthus eller frostfri vinterförvaring.", 5);
        $this->createIfNotExisting("Sötpotatis 'Vineland Early Orange', ekologisk 3-pack", 85, 53, 'Grönsaksplantor', "'Ipomoea batatas 'Vineland Early Orange', ekologisk - Pluggplanta'", 'sweetpotato.jpeg', "Ekologiskt odlad sötpotatis 'Vineland Early Orange'.Tidig. Mycket produktiv sort.Orange insida, röd utsida. Sötpotatis är en spännande grönsak som fordar mycket värme och vatten men annars är det en lättodlad växtHela serien Vineland av sötpotatis är bra anpassade för våra nordiska förhållanden.Tidigare och bättre skörd och kortare kulturtid.Planteras lite djupare och inte för små krukor innan utplantering.Planteras ut när frostrisken är över. Behöver god och kontinuerlig tillgång på vatten.Under de första 30 dagarna prioriterar plantan rotutveckling och bildar knölanlag. Undvik därför rotsnurr som medför deformerade potatisar.Bladproduktionen kommer senare.", 8);
        $this->createIfNotExisting("Tomatplanta 'Bajaja'", 49, 3, 'Grönsaksplantor', "Tomatplanta 'Bajaja' i 8 cm kruka", 'tomato.jpeg', "Mycket tidig och rikgivande, lågväxande körsbärstomat för krukodling på balkong eller uteplats. Blir översållad av röda, söta, goda tomater som väger ca.10 gram.Lättodlad sort som varken behöver bindas upp eller tjuvas. Kan gärna planteras i ampel eller balkonglåda.", 1);
        $this->createIfNotExisting("Luktärt 'White Ensign'", 29, 120, 'Kryddväxter', "Frö till Lathyrus odoratus 'White Ensign'", 'luktart.jpeg', "Ljuvlig väldoftande luktärt. Blommar rikligt från juli och är underbar i buketter. Slingrande växtsätt som behäver stöd. Utmärkt i kruka vid uteplatsen eller på balkongen där man kommer nära och kan känna den fina doften.", 1);
        $this->createIfNotExisting("Basilika 'Italiano Classico', ekologisk", 35, 15, 'Kryddväxter', "Frö till Ocimum basilicum 'Italiano Classico'", 'basil.jpeg', "En rikbärande, vacker basilika från norra Italien. Växer kompakt och passar därför att odla i kruka på fönsterbrädan eller inomhus under växtlampa året om. Trivs också i hydrokultur. Ett måste i pesto och i alla slags rätter med tomat.", 2);
        $this->createIfNotExisting("Palettblad 'Autumn Rainbow'", 49, 6, 'Palettblad', "Stickling av palettblad, Plectranthus scutellarioides 'Autumn Rainbow'", 'palettblad.jpeg', "Ett palettblad med varmröda till bruna toner på bladen som har en fin, ljusgrön kant på lätt tandad kant.", 8);
        $this->createIfNotExisting("Palettblad 'Beale Street'", 49, 29, 'Palettblad', "Plectranthus scutellarioides 'Beale Street' - 8-10 cm kruka", 'palettblad-beale.jpeg', "'Beale Street' har stora vackra vinröda blad.", 6);
        $this->createIfNotExisting("Zonalpelargon 'Catalina'", 69, 31, 'Pelargoner', "Pelargonium x hortorum 'Catalina' - 8-10 cm kruka", 'Catalina-pelargon.jpeg', "En brokbladig sort med vitkantade mellangröna blad.Blomman är dubbel i en fin cerise färg.", 9);
        $this->createIfNotExisting('P. x Pink Quink', 89, 22, 'Pelargoner', "En favorit med varmrosa blommor och vackra blad.", 'PxPinkQuink.jpeg', "P. x Pink Quink är en härlig primärhybrid med varmrosa, ganska stora blommor och ett bladverk med gröngrå blad som är mycket flikiga. Passsar bra att odla i ampel.", 8);
        $this->createIfNotExisting("Doftpelargon 'Atomic Snowflake'", 69, 86, 'Pelargoner', "Pelargonium (Doftpelargon-Gruppen) 'Atomic Snowflake' - 8-10 cm kruka", 'atomicsnowflake.jpeg', "'Atomic Snowflake' har ljusgröna blad som är variegerade i vitt till krämvitt.Blommorna är relativt stora och rosalila.Blir snabbt relativt storvuxen. Bladen avger en doft av citron/ros när de vidrörs", 5);
        $this->createIfNotExisting("Doftpelargon 'Attar of Roses'", 69, 24, 'Pelargoner', "Doftpelargon 'Attar of Roses' - 8-10 cm", 'doftpelargon-attar-of-roses.jpeg', "Doftpelargonen 'Attar of Roses' är en av de mest välkända doftpelargonerna. Både för sitt trevliga utseende, men detta är också en av de doftpelargoner som ha en underbar rosenlik doft och de godaste bladen!Plantan blir hög och bred och passar bra också att plantera i en större kruka eller till och med i rabatten där den verkligen breder ut sig.Bladen är friskt gröna med sirliga kanter. Tidig vår och på sensommaren är blomningen mest påtaglig med små, fina rosa blommor.", 3);
        $this->createIfNotExisting("Alströmeria 'Inticancha Bryce'", 79, 35, 'Sommarblommor', "Jumboplugg av Alstroemeria x hybrid", 'ahlstromeria.jpeg', "Alströmeria även kallad inkalilja är en ståtlig och vacker blomma. Blommorna påminner om liljor. Blir ca 30 cm hög.", 2);
        $this->createIfNotExisting('Chokladskära,- 3-pack', 89, 39, 'Sommarblommor', "Cosmos atrosanguineus Chocolate - Pluggplanta", 'chokladskara.jpeg', "Chokladskäran passar bra både till urnor, krukor och för plantering i rabatten. Växtsättet är överhängande och graciös, och den bildar nästan som en sky över rabattens övriga blommor.Med sin doft av kakao och sin varma brunröda färg är den ett härligt inslag i trädgården. Doftens intensitet varierar under dygnets timmar.", 1);
        $this->createIfNotExisting("Gerbera 'Garvinea Classic Femmy'", 75, 29, 'Sommarblommor', "Jumboplugg av Gerbera x jamesoni", 'gerbera-garvinea.jpeg', "Gerbera passar perfekt i kruka på uteplats eller balkong. Får stadiga stjälkar och blir ca 30 cm hög", 2);
        $this->createIfNotExisting("Jätteverbena 'Vanity', 3-pack", 79, 0, 'Sommarblommor', "Verbena bonariensis Vanity - Pluggplanta", 'jatteverbena-vanity.jpeg', "En kortare mer kompakt sort med lila-blommor. Älskas av bin och fjärilar. Passar perfekt i kruka och rabatt.", 4);
        $this->createIfNotExisting("Palettblad 'Black Dragon'", 49, 0, 'Palettblad', "Plectranthus scutellarioides 'Black Dragon'", 'black-dragon.jpeg', 'Välförgrenade växter med mycket stora, rynkade, sammetslena svarta blad med rubinröd mitt. Black Dragon växer till 45 cm hög och är en exeptionell växt för rabatter och krukor', 3);
        $this->createIfNotExisting("Palettblad 'Fairway Mosaic'", 35, 50, 'Palettblad', "Plectranthus scutellarioides 'Fairway Mosaic'", "palettblad-fairway-mosaic.jpeg", "Ger extra lågväxta, förgrenade plantor. Fairway blommar väldigt sent och ger en lång säsong av härliga färger.Planteras i kruka, eller i framkant i trädgårdsrabatten.Omplanteras efter 5 veckor från sådd", 8);
        $this->createIfNotExisting("Palettblad 'Fairway Red Velvet", 35, 31, 'Palettblad', "Frö till palettblad, Plectranthus scutellarioides 'Fairway Red Velvet'", "palettblad-red-velvet.jpeg", "Ger extra lågväxta, förgrenade plantor. Fairway blommar väldigt sent och ger en lång säsong av härliga färger.Planteras i kruka, eller i framkant i trädgårdsrabatten.Omplanteras efter 5 veckor från sådd", 5);
        $this->createIfNotExisting("Palettblad 'Giant Exhibition Magma'", 49, 10, 'Palettblad', "Frö till palettblad, Plectranthus scutellarioides 'Giant Exhibition Magma'", "palettblad-giant-exhibition-magma.jpeg", "Visar anmärkningsvärd motståndskraft mot värme.Bladen är extremt stora.Används i rabatter samt blomlådor och för krukodling. Kan odlas inomhus.Från groning till mogna plantor på 13 veckor.", 7);
        $this->createIfNotExisting("Palettblad 'Giant Exhibition Palisandra Black'", 49, 104, 'Palettblad', "Frö till palettblad, Plectranthus scutellarioides 'Giant Exhibition Palisandra Black'", "palettblad-giant-exhibition-palisandra-black.jpeg", "Visar anmärkningsvärd motståndskraft mot värme.Bladen är extremt stora.Används i rabatter samt blomlådor och för krukodling. Kan odlas inomhus.Från groning till mogna plantor på 13 veckor.", 9);
        $this->createIfNotExisting("Palettblad 'Solento Dark Cherry'", 45, 61, 'Palettblad', "Frö till palettblad, Plectranthus scutellarioides 'Solento Dark Cherry'", "palettblad-solento-dark-cherry-volmary.jpeg", "Palettblad 'Solento Dark Cherry' har en intensiv rosa bas med mörkt körsbärsröd kant och en mycket tunn grön ytterkant. Välförgrenad, rund plantstruktur. Sorten blir ca 35 cm hög och har mycket god värme- och soltålighet", 2);
        $this->createIfNotExisting("Palettblad 'Superfine Rainbow Color Pride'", 35, 20, 'Palettblad', "Frö till palettblad, Plectranthus scutellarioides 'Superfine Rainbow Color Pride'", "palettblad-superfine-rainbow-color-pride.jpeg", "Tillväxten är upprätt med utmärkt förgrening. Stora livligt färgade blad.Används i rabatter samt i blomlådor och krukor. Passar till 10 cm krukor och större. Från groning till omplantering inom ca 5 veckor.", 3);
        $this->createIfNotExisting("Palettblad 'Superfine Rainbow Festive Dance'", 35, 76, 'Palettblad', "Frö till palettblad, Plectranthus scutellarioides 'Superfine Rainbow Festive Dance'", "palettblad-rainbow-festive-dance.jpeg", "Tillväxten är upprätt med utmärkt förgrening. Stora livligt färgade blad.Används i rabatter samt i blomlådor och krukor. Passar till 10 cm krukor och större. Från groning till omplantering inom ca. 5 veckor.", 8);
        $this->createIfNotExisting("Palettblad 'Superfine Rainbow Multicolor'", 35, 15, 'Palettblad', "Frö till palettblad, Plectranthus scutellarioides 'Superfine Rainbow Multicolor'", "palettblad-superfine-rainbow-multicolor.jpeg", "Tillväxten är upprätt med utmärkt förgrening. Stora livligt färgade blad.Används i rabatter samt i blomlådor och krukor. Passar till 10 cm krukor och större. Från groning till omplantering inom ca. 5 veckor.", 6);
        $this->createIfNotExisting("Svartöga 'Sunny Susy Pink Beauty', 3-pack", 79, 49, 'Sommarblommor', "Thunbergia alata 'Sunny Susy® Pink Beauty' - Pluggplanta", "svartoga-sunny-susy-pink-beauty.jpeg", "Slingerväxt med grönt fint bladverk till de mjukt rosa blommorna. Svartöga är en mycket allsidig och användbar prydnadsväxt. Det frodiga växtsättet gör att Svartöga kan användas både till ampelplanteringar och större planteringskärl.", 9);
        $this->createIfNotExisting("Änglatrumpet, gul", 119, 26, 'Sommarblommor', "Brugmansia suaveolens", "anglatrumpet-gul.jpeg", "En mycket rikblommande änglatrumpet med guldgula 'trumpeter'.Trivs bäst utomhus sommartid. Övervintras svalt och ljust.Planteras i stor kruka. Växer snabbt. Ju större kruka, desto större planta.Gödsla och vattna rikligt.", 6);

        $seeded = true;

    }

    function createIfNotExisting($title, $price, $stockLevel, $categorytitle, $shortDesc, $img, $longDesc, $popularity)
    {
        $existing = $this->getProductByTitle($title);
        if ($existing) {
            return;
        }
        ;
        return $this->addProduct($title, $price, $stockLevel, $categorytitle, $shortDesc, $img, $longDesc, $popularity);

    }

    function addCategory($title)
    {
        $prep = $this->pdo->prepare('INSERT INTO category (title) VALUES(:title )');
        $prep->execute(["title" => $title]);
        return $this->pdo->lastInsertId();
    }


    function addProduct($title, $price, $stockLevel, $categorytitle, $shortDesc, $img, $longDesc, $popularity)
    {

        $category = $this->getCategoryByTitle($categorytitle);
        if ($category == false) {
            $this->addCategory($categorytitle);
            $category = $this->getCategoryByTitle($categorytitle);
        }

        $prep = $this->pdo->prepare('INSERT INTO products (title, price, stockLevel, categoryId,shortDesc, img, longDesc,popularity) VALUES(:title, :price, :stockLevel,:categoryId,:shortDesc,:img,:longDesc,:popularity)');
        $prep->execute(["title" => $title, "price" => $price, "stockLevel" => $stockLevel, "categoryId" => $category->id, "shortDesc" => $shortDesc, "img" => $img, "longDesc" => $longDesc, "popularity" => $popularity]);
        return $this->pdo->lastInsertId();

    }

    function initIfNotInitialized()
    {

        static $initialized = false;
        if ($initialized)
            return;


        $sql = "CREATE TABLE IF NOT EXISTS `category` (
            `id` INT AUTO_INCREMENT NOT NULL,
            `title` varchar(200) NOT NULL,
            PRIMARY KEY (`id`)
            ) ";

        $this->pdo->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `products` (
            `id` INT AUTO_INCREMENT NOT NULL,
            `title` varchar(200) NOT NULL,
            `price` INT,
            `stockLevel` INT,
            `shortDesc` varchar(200),
            `img`varchar(200),
            `longDesc`varchar(1000),
            `popularity` INT,
            `categoryId` INT NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`categoryId`)
                REFERENCES category(id)
            ) ";

        $this->pdo->exec($sql);

        $this->usersDatabase->setupUsers();
        $this->usersDatabase->seedUsers();

        $initialized = true;
    }
}
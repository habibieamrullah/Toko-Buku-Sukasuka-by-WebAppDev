<?php

$content = "";
$title = getoption("sitetitle");

if(isset($_GET["booksincategory"])){
    
    $cc = escsql($_GET["booksincategory"]);
    $title = "Buku dalam Kategori " . $cc . " - " . getoption("sitetitle");
    $content = '<div class="maxw">
    <div align="center"><h2>Buku dalam Kategori ' . $cc . '</h2></div>
    <div class="gridcontainer">
        ' . showcards("SELECT * FROM products WHERE category LIKE '%$cc%' ORDER BY id DESC") . '</div>
    </div>';
}

else if(isset($_GET["q"])){
    
    $q = escsql($_GET["q"]);
    $title = "Hasil pencarian: " . $q . " - " . getoption("sitetitle");
    $content = '<div class="maxw">
        <div align="center"><h2>Hasil pencarian: '. $q .'</h2></div>
        <div class="gridcontainer">' . showcards("SELECT * FROM products WHERE title LIKE '%$q%' OR description LIKE '%$q%' ORDER BY id DESC") . '</div>
    </div>';
}

else if(isset($_GET["pageid"])){
    $pageid = escsql($_GET["pageid"]);
    $sql = "SELECT * FROM pages WHERE id = $pageid";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    
    $title = $row["title"] . " - " . getoption("sitetitle");
    $content = '
        <div>
            <div style="background-color: #ececec; padding: 1em;">
                <div class="maxw">
                    <h2 style="margin: 0px;">' .$row["title"]. '</h2>
                </div>
            </div>
            <div class="maxw">
                '.$row["content"].'
            </div>
        </div>
    ';
}

else if(isset($_GET["product"])){
    $productid = escsql($_GET["product"]);
    $sql = "SELECT * FROM products WHERE id = $productid";
    $result = mysqli_query($connection, $sql);
    if($result){
        $row = mysqli_fetch_assoc($result);
        $title = $row["title"];
		$thumbnail = "";
		if($row["thumbnail"] != ""){
			$thumbnail = '<div class="tablecell"><img src="images/' .$row["thumbnail"]. '" style="width: 100%;"></div>';
		}
		
		$purchasebuttons = "";
		if(getoption("isselling") == 1){
			$purchasebuttons = '<div onclick="waorder()" class="waorder"><i class="fa fa-whatsapp"></i> Pesan Lewat WhatsApp</div>
                            <div onclick="addToCart(' .$row["id"]. ', \'' .$row["title"]. '\', ' .$row["currentprice"]. ', \'' .$row["thumbnail"]. '\')" class="waorder"><i class="fa fa-shopping-cart"></i> Tambahkan ke Keranjang</div>';
		}
		
        $content = '
            <div>
                <div class="maxw">
                    <div style="display: table; width: 100%; box-sizing: border-box;">' . $thumbnail . '<div class="tablecell">
                            <span style="color: #129505">Ketersediaan: '.$row["stocktext"].' | Kategori: ' .$row["category"]. '</span>
                            <h1>'.$row["title"].'</h1>
                            <h3>Deskripsi Buku:</h3>
                            <div>'.$row["description"].'</div>
                            <div>
                                <h4 style="font-size: 12px; text-decoration: line-through; display: inline-block;">Rp. ' . number_format($row["regularprice"]) . '</h4><span style="background-color: ' . getoption("primarycolor") . '; color: white; padding: 2px; margin: 2px; border-radius: 3px;">' . $row["discount"] . '%</span>
                            </div>
                            <div style="color: ' . getoption("primarycolor") . '; font-weight: bold;">
                                <h3>Rp. ' . number_format($row["currentprice"]) .'<h3>
                            </div>' . $purchasebuttons . '</div>
                    </div>
                </div>
            </div>
            <div class="maxw">
                <div align="center"><h2>Mungkin Anda Tertarik</h2></div>
                <div class="gridcontainer">' . showcards("SELECT * FROM products ORDER BY rand() LIMIT 14") . '</div>
            </div>
        ';
    }
}

else if(isset($_GET["cart"])){
    $title = "Keranjang Belanja - " . getoption("sitetitle");
    $content = '
        <div class="maxw">
            <div align="center"><h2><i class="fa fa-shopping-cart"></i> Keranjang Belanja</h2></div>
            <div id="shoppingcart"></div>
        </div>
    ';
}

else if(isset($_GET["howtopay"])){
	
	$content = '
        <div class="maxw">
            <div align="center"><h2><i class="fa fa-credit-card"></i> Cara Berbelanja</h2></div>
            <div>' .getoption("howtobuy"). '</div>
        </div>
    ';
}

else{
    $content = '<div style="margin-bottom: 20px;">
        <div class="maxw homeslider">
            <img src="slider1.jpg" style="width: 100%;">
            <img src="slider2.jpg" style="width: 100%;">
            <img src="slider3.jpg" style="width: 100%;">
        </div>
    </div>
    <div class="maxw">
        <div align="center"><h2>TERBARU</h2></div>
        <div class="gridcontainer">' . showcards("SELECT * FROM products ORDER BY id DESC LIMIT 14") . '</div>
    </div>
    <div>
    <div class="maxw">
        <div align="center"><h2>MUNGKIN MENARIK</h2></div>
        <div class="gridcontainer">' . showcards("SELECT * FROM products ORDER BY rand() LIMIT 14") . '</div>
    </div>';
    
    $sql = "SELECT * FROM categories ORDER BY title DESC";
    $result = mysqli_query($connection, $sql);
    if($result){
        while($row = mysqli_fetch_assoc($result)){
            $curcat = $row["title"];
            $content .= '
                <div class="maxw">
                    <div align="center"><h2>Buku ' . $curcat . ' Terbaru</h2></div>
                    <div class="gridcontainer">' . showcards("SELECT * FROM products WHERE category LIKE '%$curcat%' ORDER BY id DESC LIMIT 5") . '</div>
                </div>
            ';
        }
    }
}
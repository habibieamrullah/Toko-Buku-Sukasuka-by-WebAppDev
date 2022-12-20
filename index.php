<?php
include("dbcon.php");
include("functions.php");
include("contentmanager.php");

?>

<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title ?></title>
        <meta name="description" content="<?php echo getoption("metadescription") ?>">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
        
        <script type="text/javascript" src="jquery.min.js"></script>
        
        <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
		<link rel="stylesheet" type="text/css" href="slick/slick.css"/>
        <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
        <script type="text/javascript" src="slick/slick.min.js"></script>
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Maven+Pro&display=swap" rel="stylesheet">

        <style>
            /* SCROLLBAR STYLING */
        	/* width */
        	.gridcontainer::-webkit-scrollbar {
        		width: 10px;
        		height: 10px;
        	}
        	/* Track */
        	.gridcontainer::-webkit-scrollbar-track {
        		background: #f2f2f2; 
        	}
        	/* Handle */
        	.gridcontainer::-webkit-scrollbar-thumb {
        		background: #D22135; 
        	}
        	/* Handle on hover */
        	.gridcontainer::-webkit-scrollbar-thumb:hover {
        		background: #FF3B51; 
        	}
        	html{
        	    margin: 0px;
        	    padding: 0px;
        	}
            h1, h2, h3, h4, h5, p{
                margin: 0px;
                margin-bottom: 10px;
            }
            body{
                padding: 0px;
                margin: 0px;
                font-family: 'Maven Pro', sans-serif;
                font-size: 14px;
                overflow-x: hidden;
            }
            .topribbon{
                background-color: <?php echo getoption("primarycolor") ?>;
                color: white;
            }
            .maxw{
                display: block;
                width: 100%;
                max-width: 920px;
                margin: 0 auto;
                padding: 10px;
                box-sizing: border-box;
            }
            .topribbonitem{
                padding: 0.5em;
            }
            
            .gridcontainer{
        		overflow: auto;
        		white-space: nowrap;
        		margin-bottom: 50px;
        	}
        	
        	.productcard{
        	    display: inline-block;
        	    vertical-align: top;
        	    white-space: normal;
		        width: 160px;
		        margin: 10px;
        	}
        	
        	.productthumb{
        	    width: 160px;
		        height: 256px;
        	}
            
            .footer{
                background-color: <?php echo getoption("primarycolor") ?>;
                color: white;
                margin: 0px;
                padding-bottom: 32px;
            }
            
            .tablecell{
                display: table-cell;
                width: 50%;
                vertical-align: top;
                padding: 5px;
            }
            
            a{
                color: inherit;
                text-decoration: none;
            }
            
            a:hover{
                text-decoration: underline;
            }
            
            .anou:hover{
                text-decoration: none;
            }
            
            .logoplaceholder{
                text-align: left;
            }
            
            #searchinput{
                
                background-color: inherit;
                padding: 0.5em;
                width: 100%;
                font-size: 1em;
                color: white;
                box-sizing: border-box;
                border: none;
                outline: none;
                border-bottom: 1px solid white;
            }
            
            #searchinput::placeholder {
                color: white;
            }
            
            .waorder{
                background-color: #129505;
                padding: 0.5em;
                border-radius: 5px;
                margin-top: 5px;
                margin-bottom: 5px;
                color: white;
                font-weight: bold;
                display: inline-block;
                cursor: pointer;
                transition: all 500ms;
            }
            
            .waorder:hover{
                background-color: green;
            }
            
            label{
                display: block;
            }
            input{
                display: block;
                margin-bottom: 1em;
                padding: 1em;
                width: 50%;
            }
            textarea{
                display: block;
                padding: 1em;
                width: 50%;
            }
            
            /* mobile view */
            @media (max-width: 920px){
            	.tablecell{
            		display: block;
            		width: 100%;
            		padding-left: 0px;
            		padding-right: 0px;
            	}
            	.logoplaceholder{
                    text-align: center;
                }
            }
        </style>
        
    </head>
    <body>
        
        <div class="topribbon">
            <div class="maxw">
                <div style="display: table; width: 100%;">
                    <div style="display: table-cell; vertical-align: middle;">
                        <div class="topribbonitem" id="howtopaybutton"><?php if(getoption("isselling") == 1){ ?><i class="fa fa-credit-card"></i> <a href="?howtopay">Cara Berbelanja</a> | <?php } ?><i class="fa fa-phone"></i> <a href="tel:+<?php echo getoption("adminwhatsapp") ?>"><?php echo getoption("adminwhatsapp") ?></a></div>
                        <div class="topribbonitem" id="searchinputholder" style="display: none; padding: 0px;"><input id="searchinput" placeholder="Ketik judul buku..." onkeyup="booksearch()"></div>
                    </div>
                    <div style="display: table-cell; text-align: right; vertical-align: middle; width: 20%;">
                        <div style="display: inline-block;" onclick="toggleSearchInput()"><i class="fa fa-search" style="font-size: 1em; cursor: pointer;"></i></div>
						<?php if(getoption("isselling") == 1){ ?>
                        <div style="display: inline-block;" onclick="goToCart()"><i class="fa fa-shopping-cart" style="font-size: 1em; cursor: pointer;"></i> <?php } ?></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div>
            <div class="maxw logoplaceholder" style="padding-top: 20px; padding-bottom: 10px;">
                <a href="index.php"><img src="logotokobuku.png"></a>
            </div>
        </div>
        
        <div>
            <?php echo $content; ?>
        </div>
        
        <div class="footer">
            <div class="maxw" style="padding-top: 30px;">
                
                <div style="display: table; width: 100%; box-sizing: border-box;">
                    
                    <div class="tablecell">
                        <?php if(getoption("isselling") == 1){ ?>
                        <h2>Metode Pembayaran</h2>
                        <img src="pembayaran.png" style="width: 100%; max-width: 256px;">
                        <br><br>
						<?php } ?>
                        <h2>Alamat</h2>
						<?php echo getoption("shopaddress") ?>
                        
                        
                        <p>© Copyright <?php echo date("Y"); ?> - <?php echo $title ?> - All rights reserved.</p>
                    </div>
                    
                    <div class="tablecell">
                        <div style="padding-bottom: 10px;">
                            <h2>Kategori Buku</h2>
                            <?php 
                            $sql = "SELECT * FROM categories ORDER BY title ASC";
                            $result = mysqli_query($connection, $sql);
                            while($row = mysqli_fetch_assoc($result)){
                                ?>
                                <div style="display: inline-block;"><a href="?booksincategory=<?php echo $row["title"] ?>"><i class="fa fa-tag"></i> <?php echo $row["title"] ?></a></div>
                                <?php
                            }
                            ?>
                        </div>
                        <h2>Baru Ditambahkan</h2>
                        <div style="padding-bottom: 10px; width: 100%;">
                            <?php
                            $sql = "SELECT * FROM products ORDER BY id DESC LIMIT 5";
                            $result = mysqli_query($connection, $sql);
                            if($result){
                                while($row = mysqli_fetch_assoc($result)){
                                    ?>
                                    
                                    <div style="display: inline-block; margin-right: 3px; vertical-align: top;">
										<?php if($row["thumbnail"] != ""){ ?>
                                        <a href="?product=<?php echo $row["id"] ?>" class="anou">
                                            <img src="images/<?php echo $row["thumbnail"] ?>" style="width: 64px;">
                                        </a>
										<?php } ?>
                                    </div>
                                    
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        
        <div style="position: fixed; right: 0; bottom: 0;">
            <img src="whatsapp.png" style="width: 48px; margin: 1em; cursor: pointer;" onclick="sendwa()">
        </div>
        
        
        <script>
            function toggleSearchInput(){
                $("#searchinputholder").toggle();
                $("#howtopaybutton").toggle();
                $("#searchinput").focus();
            }
            
            var bstimeout;
            function booksearch(){
                clearTimeout(bstimeout);
                bstimeout = setTimeout(function(){
                    var searchterm = $("#searchinput").val();
                    if(searchterm.length >= 3){
                        location.href = "?q=" + searchterm;
                    }
                }, 2000);
            }
            
            $('.homeslider').slick({
                autoplaySpeed: 3000,
                autoplay : true,
                infinite: true,
				arrows : true,
            });

            
            function sendwa(){
    			var wamsg = encodeURI(location.href + "\n\nSalam Admin, saya memiliki pertanyaan...");
    			location.href = "https://wa.me/<?php echo getoption("adminwhatsapp") ?>?text="+wamsg;
            }
            
            function waorder(){
                var wamsg = encodeURI(location.href + "\n\nSalam Admin, saya Ingin membeli buku " + $("title").html());
    			location.href = "https://wa.me/<?php echo getoption("adminwhatsapp") ?>?text="+wamsg;
            }
            
            function goToCart(){
                location.href = "?cart";
            }
            
            function thousandSep(x){
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
            
            
            //Shopping Cart Scripting
            var shoppingcartdata = {
                books : [],
                name : "",
                phone : "",
                email : "",
                address : "",
            };
            if(localStorage.getItem("nahcart") !== null){
                loadCartData();
            }else{
                saveCartData();
            }
            
            function saveCartData(){
                localStorage.setItem("nahcart", JSON.stringify(shoppingcartdata));
                
            }
            
            function loadCartData(){
                shoppingcartdata = JSON.parse(localStorage.getItem("nahcart"));
            }
            
            function saveCartUserInfo(){
                shoppingcartdata.name = $("#cartname").val();
                shoppingcartdata.phone = $("#cartphone").val();
                shoppingcartdata.email = $("#cartemail").val();
                shoppingcartdata.address = $("#cartaddress").val();
                saveCartData();
            }
            
            function addToCart(id, title, price, thumb){
                
                var currentqty = 1;
                for(var i = 0; i < shoppingcartdata.books.length; i++){
                    if(shoppingcartdata.books[i].id == id){
                        currentqty += shoppingcartdata.books[i].qty;
                    }
                }
                
                shoppingcartdata.books.push({
                    id : id,
                    title : title, 
                    price : price,
                    thumb : thumb,
                    qty : currentqty,
                });
                saveCartData();
                
                location.href = "?cart";
            }
            
            
            <?php
            if(isset($_GET["cart"])){
                
                ?>
                
                var cartitems = "<div style='margin-bottom: 2em; padding: 2em; text-align: center;'>Anda belum menambahkan buku ke dalam keranjang belanja.</div>";
                var cartuserinfo = "<div><h3>Data diri Anda</h3><label>Nama:</label><input onkeyup='saveCartUserInfo();' id='cartname' value='"+shoppingcartdata.name+"'><label>No HP</label><input onkeyup='saveCartUserInfo();' id='cartphone' value='"+shoppingcartdata.phone+"'><label>Email</label><input onkeyup='saveCartUserInfo();' id='cartemail' value='"+shoppingcartdata.email+"'><label>Alamat Pengiriman</label><textarea onkeyup='saveCartUserInfo();' id='cartaddress'>"+shoppingcartdata.address+"</textarea></div><div class='waorder'><i class='fa fa-shopping-cart'></i> Kirim Pemesanan</div>";
                
                if(shoppingcartdata.books.length > 0){
                    
                    cartitems = "<table>";
                    for(var i = 0; i < shoppingcartdata.books.length; i ++){
                        var total = "Rp. " + thousandSep(shoppingcartdata.books[i].price * shoppingcartdata.books[i].qty);
                        cartitems += "<tr><td><img src='images/" +shoppingcartdata.books[i].thumbnail+ "' style='height: 32px;'></td><td>" +shoppingcartdata.books[i].title+ "</td><td>" + "Rp. " + thousandSep(shoppingcartdata.books[i].price) + "</td><td>" +shoppingcartdata.books[i].qty+ "</td><td>" +total+ "</td></tr>";
                    }
                    cartitems += "</table>"
                    cartitems = "<div style='margin-bottom: 2em; padding: 2em; text-align: center;'>" + cartitems + "</div>";
                }
                
                $("#shoppingcart").html(cartitems + cartuserinfo);
                <?php
                
            }
            ?>
            
        </script>
        
    </body>
</html>
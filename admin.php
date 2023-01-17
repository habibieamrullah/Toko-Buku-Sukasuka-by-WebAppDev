<?php

session_start();

include("dbcon.php");
include("functions.php");



?>
<!DOCTYPE html>
<html>
    <head>
        <title>Admin Toko Buku</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
        
        <link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Maven+Pro&display=swap" rel="stylesheet">
        
        <script src="jquery.min.js"></script>
        <script src="jscolor.min.js"></script>
        
        <script src="tinymce/tinymce.min.js"></script>
        <script>
			tinymce.init({ selector : 'textarea' , plugins : 'directionality, code', toolbar: "ltr rtl | alignleft aligncenter alignright alignjustify | outdent indent | sizeselect | bold italic | fontselect |  fontsizeselect", relative_urls: false, remove_script_host : true, });
		</script>
        
        <style>
            
            body{
                font-family: 'Maven Pro', sans-serif;
                background-color: #424242;
            }
            
            a{
                color: inherit;
                text-decoration: underline;
            }
            
            a:hover{
                text-decoration: none;
            }
            
            table {
                border-collapse: collapse;
                border: 1px solid;
            }
            
            tr:nth-child(even){background-color: #f2f2f2;}

            tr:hover {background-color: #ddd;}
            
            th {
              padding: 1em;
              text-align: left;
              background-color: #04AA6D;
              color: white;
            }
            td{
              padding: 0.5em;  
            }
            
            .admincontainer{
                max-width: 920px;
                margin: 0 auto;
                margin-top: 5em;
                background-color: #fafafa;
                padding: 1em;
            }
            
            .loginpage{
                max-width: 256px; margin: 0 auto; margin-top: 5em; background-color: #424242;
                padding: 1em;
                background-color: white;
            }
        
            input{
                display: block;
                box-sizing: border-box;
                width: 100%;
                padding: 1em;
                margin-bottom: 1em;
                margin-top: 0.25em;
            }
            
            select{
                margin-bottom: 1em;
            }
            
            textarea{
                display: block;
                box-sizing: border-box;
                width: 100%;
                padding: 1em;
                margin-bottom: 1em;
                margin-top: 0.25em;
            }
            
            .alert{
                display: inline-block;
                padding: 0.25em;
                border-radius: 5px;
                margin-bottom: 5px;
                background-color: green;
                color: white;
            }
        </style>
    </head>
    <body>
        <?php
        if(isset($_SESSION["adminsession"])){
            
            ?>
            <div class="admincontainer">
                <?php
                
                //Admin init
                
                //Products table
                maketable("products");
                makecolumn("title", "products", "VARCHAR(300) NOT NULL");
                makecolumn("regularprice", "products", "INT(6) NOT NULL");
                makecolumn("currentprice", "products", "INT(6) NOT NULL");
                makecolumn("stock", "products", "INT(6) NOT NULL");
                makecolumn("stocktext", "products", "VARCHAR(300) NOT NULL");
                makecolumn("catid", "products", "INT(6) NOT NULL");
                makecolumn("discount", "products", "INT(6) NOT NULL");
                makecolumn("views", "products", "INT(6) NOT NULL");
                makecolumn("category", "products", "VARCHAR(300) NOT NULL");
                makecolumn("weight", "products", "VARCHAR(300) NOT NULL");
                makecolumn("timestamp", "products", "VARCHAR(300) NOT NULL");
                makecolumn("description", "products", "VARCHAR(1500) NOT NULL");
                makecolumn("thumbnail", "products", "VARCHAR(300) NOT NULL");
                
                //Category table
                maketable("categories");
                makecolumn("title", "categories", "VARCHAR(300) NOT NULL");
                
                //Pages table
                maketable("pages");
                makecolumn("title", "pages", "VARCHAR(300) NOT NULL");
                makecolumn("content", "pages", "TEXT NOT NULL");
                
                
                //Table Options -> don't modify
                maketable($tableoptions);
                makecolumn("optionname", $tableoptions, "VARCHAR (300) NOT NULL");
                makecolumn("optionvalue", $tableoptions, "VARCHAR (2000) NOT NULL");
                //--> don't modify
    
                
                ?>
                <h1><a href="admin.php">Dasbor</a></h1>
                <p>
                    <a href="?products">Semua Produk</a>
                    | <a href="?addproduct">Tambah Produk</a>
                    | <a href="?categories">Kategori</a>
                    | <a href="?pages">Halaman</a>
                    | <a href="?settings">Pengaturan</a>
                </p>
                <?php
                
                
                if(isset($_GET["settings"])){
                    //Web settings
                    
                    ?>
                    
                    <h3>Pengaturan Web</h3>
                    
                    <?php
                    if(isset($_POST["sitetitle"])){
                        setoption("sitetitle", escsql($_POST["sitetitle"]));
                        setoption("metadescription", escsql($_POST["metadescription"]));
                        setoption("primarycolor", escsql($_POST["primarycolor"]));
                        setoption("adminwhatsapp", escsql($_POST["adminwhatsapp"]));
                        setoption("isselling", escsql($_POST["isselling"]));
                        setoption("howtobuy", escsql($_POST["howtobuy"]));
                        setoption("shopaddress", escsql($_POST["shopaddress"]));
                        
                        ?>
                        <div class="alert">Settings updated!</div>
                        <?php
                    }
                    ?>
                    
                    <form method="post">
                        
                        <div>
                            <label>Judul Situs</label>
                            <input name="sitetitle" value="<?php echo getoption("sitetitle") ?>">
                        </div>
                        
                        <div>
                            <label>Deskripsi</label>
                            <input name="metadescription" value="<?php echo getoption("metadescription") ?>">
                        </div>
                        
                        <div>
                            <label>Warna Utama</label>
                            <input name="primarycolor" value="<?php echo getoption("primarycolor") ?>" data-jscolor="{}">
                            
                        </div>
                        
                        <div>
                            <label>No WA Admin</label>
                            <input name="adminwhatsapp" value="<?php echo getoption("adminwhatsapp") ?>">
                            
                        </div>
						
						<div>
                            <label>Apakah Berjualan Buku?</label>
							<select name="isselling">
								<?php
								if(getoption("isselling") == 1){
									?>
									<option value=1 selected>Ya</option>
									<option value=0>Tidak</option>
									<?Php
								}else{
									?>
									<option value=1>Ya</option>
									<option value=0 selected>Tidak</option>
									<?Php
								}
								?>
							</select>
                            
                        </div>
						
						<div>
							<label>Teks Cara Berbelanja</label>
							<textarea name="howtobuy"><?php echo getoption("howtobuy") ?></textarea>
						</div>
						
						<br><br>
						<div>
							<label>Alamat Toko</label>
							<textarea name="shopaddress"><?php echo getoption("shopaddress") ?></textarea>
						</div>
                        
                        <div>
                            <input type="submit" value="Perbarui">
                        </div>
                        
                    </form>
                    <?php
                }
                
                else if(isset($_GET["categories"])){
                    
                    if(isset($_GET["delete"])){
                        $id = escsql($_GET["delete"]);
                        mysqli_query($connection, "DELETE FROM categories WHERE id = $id");
                        ?>
                        <div class="alert">Kategori berhasil dihapus.</div>
                        <?php
                    }
                    
                    if(isset($_POST["category"])){
                        $title = escsql($_POST["category"]);
                        mysqli_query($connection, "INSERT INTO categories (title) VALUES ('$title')");
                        ?>
                        <div class="alert">Kategori baru telah ditambahkan.</div>
                        <?php
                    }
                    
                    ?>
                    <h3>Kategori</h3>
                    <h4>Tambah baru</h4>
                    <form method="post">
                        <input type="text" name="category" placeholder="Judul Kategori">
                        <input type="submit" value="Tambah">
                    </form>
                    
                    <h4>Daftar kategori yang sudah ditambahkan</h4>
                    <?php
                    
                    $sql = "SELECT * FROM categories ORDER BY title ASC";
                    $result = mysqli_query($connection, $sql);
                    if($result){
                        while($row = mysqli_fetch_assoc($result)){
                            ?>
                            <p><?php echo $row["title"] ?> | <a href="?categories&delete=<?php echo $row["id"] ?>" style="color: red;"><i class="fa fa-trash"></i> Hapus</a></p>
                            <?php
                        }
                    }
                    
                }
                
                else if(isset($_GET["addproduct"])){
                    
                    
                    ?>
                    <h3>Tambah Produk</h3>
                    
                    <?php
                    if(isset($_POST["title"])){
                        include("compressimage.php");
                        
                        $title = escsql($_POST["title"]);
                        $category = escsql($_POST["category"]);
                        $regularprice = escsql($_POST["regularprice"]);
                        $currentprice = escsql($_POST["currentprice"]);
                        $discount = escsql($_POST["discount"]);
                        $stock = escsql($_POST["stock"]);
                        $stocktext = escsql($_POST["stocktext"]);
                        $weight = escsql($_POST["weight"]);
                        $description = escsql($_POST["description"]);
                        
                        
                        $thumbnailname = "thumb-".urlfriendly($title);
			            $uploadedthumbnail = uploadAndResize($thumbnailname, "thumbnail", "images/", 512);
			            
			            $timestamp = getCurrentMillisecond();
			            mysqli_query($connection, "INSERT INTO products (title, category, regularprice, currentprice, discount, stock, stocktext, weight, description, thumbnail, timestamp) VALUES ('$title', '$category', $regularprice, $currentprice, $discount, $stock, '$stocktext', '$weight', '$description', '$uploadedthumbnail', '$timestamp')");
			            
                        ?>
                        <div class="alert">Produk telah ditambahkan.</div>
                        <?php
                    }
                    ?>
                    
                    <form method="post" enctype="multipart/form-data">
                        
                        <label>Judul Buku</label>
                        <input name="title">
                        
                        <div>
                            <label>Kategori</label>
                            <select name="category">
                                <?php
                                $sql = "SELECT * FROM categories ORDER BY title ASC";
                                $result = mysqli_query($connection, $sql);
                                while($row = mysqli_fetch_assoc($result)){
                                    ?>
                                    <option><?php echo $row["title"] ?></option>
                                    <?php
                                }
                                ?>
                                
                            </select>
                            
                        </div>
                        
                        <label>Harga Normal</label>
                        <input type="number" name="regularprice" id="regularprice" onkeyup="UpdateProductForm()">
                        
                        <label>Diskon dalam persen</label>
                        <input type="number" name="discount" id="discount" onkeyup="UpdateProductForm()" value="0">
                        
                        <label>Harga setelah diskon</label>
                        <input type="number" name="currentprice" id="currentprice" readonly>
                        
                        <label>Jumlah Stok</label>
                        <input type="number" name="stock" value="1" id="stock" onkeyup="UpdateProductForm()" >
                        
                        <label>Teks Stok</label>
                        <input type="text" name="stocktext" value="Tersedia" id="stocktext" readonly>
                        
                        <label>Berat</label>
                        <input type="number" name="weight">
                        
                        <label>Gambar Produk</label>
                        <input type="file" name="thumbnail" accept="image/*" >
                        
                        <label>Deskripsi</label>
                        <textarea name="description"></textarea>
                        
                        <input type="submit" value="Tambahkan">
                        
                    </form>
                    
                    
                    <?php
                    
                }
                
                else if(isset($_GET["editproduct"])){
                    $id = escsql($_GET["editproduct"]);
                    $sql = "SELECT * FROM products WHERE id = $id";
                    $result = mysqli_query($connection, $sql);
                    if($result){
                        $row = mysqli_fetch_assoc($result);
                    }
                    
                    ?>
                    
                    <h3>Edit Detil Produk</h3>
                    
                    <?php
                    if(isset($_POST["title"])){
                        
                        $title = escsql($_POST["title"]);
                        $category = escsql($_POST["category"]);
                        $regularprice = escsql($_POST["regularprice"]);
                        $currentprice = escsql($_POST["currentprice"]);
                        $discount = escsql($_POST["discount"]);
                        $stock = escsql($_POST["stock"]);
                        $stocktext = escsql($_POST["stocktext"]);
                        $weight = escsql($_POST["weight"]);
                        $description = escsql($_POST["description"]);
                        
			            
			            mysqli_query($connection, "UPDATE products SET title = '$title', category = '$category', regularprice = $regularprice, currentprice = $currentprice, discount = $discount, stock = $stock, stocktext = '$stocktext', weight = '$weight', description = '$description' WHERE id = $id");
			            
                        ?>
                        <div class="alert">Detil produk telah diperbarui.</div>
                        <?php
                    }
                    ?>
                    
                    
                    <form method="post" enctype="multipart/form-data">
                        
                        <label>Judul Buku</label>
                        <input name="title" value="<?php echo $row["title"] ?>">
                        
                        <div>
                            <label>Kategori</label>
                            <select name="category" value="<?php echo $row["category"] ?>">
                                <?php
                                $sql = "SELECT * FROM categories ORDER BY title ASC";
                                $result = mysqli_query($connection, $sql);
                                while($crow = mysqli_fetch_assoc($result)){
                                    ?>
                                    <option><?php echo $crow["title"] ?></option>
                                    <?php
                                }
                                ?>
                                <option selected><?php echo $row["category"] ?></option>
                            </select>
                            
                        </div>
                        
                        <label>Harga Normal</label>
                        <input type="number" name="regularprice" id="regularprice" onkeyup="UpdateProductForm()" value="<?php echo $row["regularprice"] ?>">
                        
                        <label>Diskon dalam persen</label>
                        <input type="number" name="discount" id="discount" onkeyup="UpdateProductForm()" value="<?php echo $row["discount"] ?>">
                        
                        <label>Harga setelah diskon</label>
                        <input type="number" name="currentprice" id="currentprice" readonly value="<?php echo $row["currentprice"] ?>">
                        
                        <label>Jumlah Stok</label>
                        <input type="number" name="stock" value="1" id="stock" onkeyup="UpdateProductForm()" value="<?php echo $row["stock"] ?>">
                        
                        <label>Teks Stok</label>
                        <input type="text" name="stocktext" value="Tersedia" id="stocktext" readonly value="<?php echo $row["stocktext"] ?>">
                        
                        <label>Berat</label>
                        <input type="number" name="weight" value="<?php echo $row["weight"] ?>">
                        
                        <label>Deskripsi</label>
                        <textarea name="description"><?php echo $row["description"] ?></textarea>
                        
                        <input type="submit" value="Tambahkan">
                        
                    </form>
                    
                    <p>Hapus produk? Klik <a href="?deleteproduct=<?php echo $id ?>">di sini</a></p>
                    
                    <?php
                    
                }
                
                else if(isset($_GET["deleteproduct"])){
                    $id = escsql($_GET["deleteproduct"]);
                    mysqli_query($connection, "DELETE FROM products WHERE id = $id");
                    ?>
                    <div class="alert">Produk sudah dihapus</div>
                    <?php
                }
                    
                else if(isset($_GET["products"])){
                    ?>
                    <h3>Semua Produk</h3>
                    
                    <p>Klik <a href="?addproduct">di sini</a> untuk menambahkan produk baru.</p>
                    
                    <?php
                    $sql = "SELECT * FROM products ORDER BY id DESC";
                    $result = mysqli_query($connection, $sql);
                    if($result){
                        ?>
                        <table>
                            <tr>
                                <th style="text-align: left; width: 50%">Judul</th>
                                <th style="text-align: right;">Harga</th>
                                <th>Edit</th>
                            </tr>
                            <?php
                            while($row = mysqli_fetch_assoc($result)){
                                ?>
                                <tr>
                                    <td><a href="https://<?php echo $_SERVER['SERVER_NAME'] ?>?product=<?php echo $row["id"] ?>" target="_blank"><?php echo $row["title"] ?></a></td>
                                    <td style="text-align: right;">Rp. <?php echo number_format($row["currentprice"]) ?></td>
                                    <td><a href="?editproduct=<?php echo $row["id"] ?>"><i class="fa fa-edit"></i> Edit</a></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                        <?php
                    }
                }
                
                else if(isset($_GET["pages"])){
                    
                    ?>
                    <h3>Halaman</h3>
                    
                    <?php
                    if(isset($_POST["pagetitle"])){
                        $pagetitle = escsql($_POST["pagetitle"]);
                        $pagecontent = escsql($_POST["pagecontent"]);
                        mysqli_query($connection, "INSERT INTO pages (title, content) VALUES ('$pagetitle', '$pagecontent')");
                    }
                    ?>
                    
                    <h4>Tambah baru</h4>
                    <form method="post">
                        
                        <label>Judul</label>
                        <input name="pagetitle">
                        <label>Konten</label>
                        <textarea name="pagecontent"></textarea>
                        <input type="submit" value="Tambahkan">
                        
                    </form>
                    
                    <h4>Halaman-halaman yang ada</h4>
                    
                    <?php
                    $sql = "SELECT * FROM pages ORDER BY id DESC";
                    $result = mysqli_query($connection, $sql);
                    while($row = mysqli_fetch_assoc($result)){
                        ?>
                        <p><a href="https://<?php echo $_SERVER['SERVER_NAME'] ?>?pageid=<?php echo $row["id"] ?>" target="_blank"><?php echo $row["title"] ?></a> | <a href="?editpage=<?php echo $row["id"] ?>">Edit</a></p>
                        <?php
                    }
                    
                }
                
                else if(isset($_GET["editpage"])){
                    $pageid = escsql($_GET["editpage"]);
                    ?>
                    <h3>Edit Halaman</h3>
                    <?php
                    
                    if(isset($_POST["pagetitle"])){
                        $pagetitle = escsql($_POST["pagetitle"]);
                        $pagecontent = escsql($_POST["pagecontent"]);
                        mysqli_query($connection, "UPDATE pages SET title = '$pagetitle', content = '$pagecontent' WHERE id = $pageid");
                        
                        ?>
                        <div class="alert">Halaman telah diperbarui.</div>
                        <?php
                    }
                    
                    
                    
                    
                    $sql = "SELECT * FROM pages WHERE id = $pageid";
                    $result = mysqli_query($connection, $sql);
                    $row = mysqli_fetch_assoc($result);
                    
                    ?>
                    
                    <form method="post">
                        
                        <label>Judul</label>
                        <input name="pagetitle" value="<?php echo $row["title"] ?>">
                        <label>Konten</label>
                        <textarea name="pagecontent"><?php echo $row["content"] ?></textarea>
                        <input type="submit" value="Tambahkan">
                        
                    </form>
                    <?php
                }
                
                else if(isset($_GET["rescancategories"])){
                    $sql = "SELECT * FROM products ORDER BY category ASC";
                    $result = mysqli_query($connection, $sql);
                    while($row = mysqli_fetch_assoc($result)){
                        $cc = $row["category"];
                        $xsql = "SELECT * FROM categories WHERE title = '$cc'";
                        if(mysqli_num_rows(mysqli_query($connection, $xsql)) == 0){
                            mysqli_query($connection, "INSERT INTO categories (title) VALUES ('$cc')");
                        }
                    }
                }
                
                else{
                    echo "Selamat datang!";
                }
                
                ?>
            </div>
            <?php
            

        }else{
            
            ?>
            <div class="loginpage">
                <h1>Login Admin</h1>
                <?php
                
                if(isset($_POST["username"])){
                    $u = $_POST["username"];
                    $p = $_POST["password"];
                    
                    if($u == $adminusername && $p == $adminpassword){
                        ?>
                        <p>Login ok. Klik <a href="admin.php">di sini</a> untuk menuju Dasbor.</p>
                        <?php
                        $_SESSION["adminsession"] = $adminpassword;
                    }else{
                        echo "Login error!";
                    }
                    
                }else{
                    ?>
                    <form method="post">
                        <label>Username</label>
                        <input type="name" name="username">
                        <label>Password</label>
                        <input type="password" name="password">
                        <input type="submit" value="Masuk">
                    </form>
                    <?php
                }
                
                
                ?>
            </div>
            <?php
            
        }
        ?>
        
        <script>
            $(document).ready(function(){
                setTimeout(function(){
                    $(".alert").slideUp();
                },3000);
                
            });
            
            function UpdateProductForm(){
                var regularprice = $("#regularprice").val();
                var discount = $("#discount").val();
                var stock = $("#stock").val();
                var currentprice = 0;
                if(regularprice != 0){
                    $("#currentprice").val(regularprice - ((discount/100) * regularprice));
                }
                if(stock > 0){
                    $("#stocktext").val("Stok Tersedia");
                }else{
                    $("#stocktext").val("Tidak Tersedia");
                }
            }
        </script>
    </body>
</html>


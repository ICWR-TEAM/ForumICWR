<?php

error_reporting(0);
ob_start();
session_start();
session_regenerate_id();
include("config.php");
$no=1;


// if ($_GET['login']) {
//   $_SESSION['login']="awok";
// }
// if($_GET['menu']=="logout"){
//   session_destroy();
//   header("location:index.php");
// }
 ?>
 <!doctype html>
 <html lang="en">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
     <style>

     </style>
     <title><!-- sub --></title>
     <?php $retitle="$judul"; ?>
   </head>
   <body>

     <!-- navbar -->
     <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
       <div class="container">
         <?php
         $explode_sessionUserNavbar=explode("--p3m1s4h--",@$_SESSION['username']);
          ?>
         <a class="navbar-brand" href="#"><?php if(!@$_SESSION['username']){ echo $forum_name; }else{ echo $forum_name." | ".xss($explode_sessionUserNavbar['1']); } ?></a>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
           <span class="navbar-toggler-icon"></span>
         </button>

         <div class="collapse navbar-collapse" id="navbarSupportedContent">
           <ul class="navbar-nav ml-auto">
             <li class="nav-item">
               <a class="d-flex justify-content-center nav-link js text-white" id="nav-item" href="index.php">Home</a>
             </li>
             <li class="nav-item">
               <a class="d-flex justify-content-center nav-link js text-white" id="nav-item" href="?menu=about">About</a>
             </li>
             <?php if (@$_SESSION['login']): ?>
             <li class="nav-item">
               <a class="d-flex justify-content-center nav-link js text-white" id="nav-item" href="?menu=tambah_topik">Add Topic</a>
             </li>
             <?php endif; ?>
             <?php if (@$_SESSION['login']): ?>
             <li class="nav-item">
               <a class="d-flex justify-content-center nav-link js text-white" id="nav-item" href="?page=profile">Profile</a>
             </li>
             <?php endif; ?>
             <?php if (!@$_SESSION['username']): ?>
             <li class="nav-item">
               <a class="d-flex justify-content-center nav-link js text-white" id="nav-item" href="?menu=login">Login</a>
             </li>
             <?php endif; ?>
             <?php if (@$_SESSION['login']): ?>
               &nbsp;&nbsp;
               <li class="nav-item">
                 <a class="nav-link btn btn-outline-warning text-white" id="nav-item" href="?menu=logout">Logout</a>
               </li>
             <?php endif; ?>
             &nbsp;&nbsp;
             <li class="nav-item">
               <a class="nav-link btn btn-outline-danger text-white" id="disclaimer-nav" href="?menu=disclaimer">Disclaimer</a>
             </li>
           </ul>
         </div>
       </div>
     </nav>
     <!-- end navbar -->

     <!-- home -->
     <div class="container mt-4">
       <br><br>
       <div class="card border border-dark mt-4 bg-dark text-white">
         <div class="card-body" style="padding: 30px;">
           <h2 class="text-center"><?php echo $forum_name; ?></h2>
         </div>
       </div>
       <?php if(!$_GET){ ?>
         <?php $retitle="Forum bersama"; ?>
         <div class="row">
           <div class="col-md-8 col-12 col-sm-12 mt-4">
             <div class="card border border-dark">
               <div class="card-body">
                 <pre>
                   <table class="table table-hover">
                     <thead>
                       <tr>
                         <th width="50px">No</th>
                         <th width="250px">Category</th>
                         <th>Detail</th>
                       </tr>
                     </thead>
                     <tbody>
                       <?php
                       $query=mysqli_query($conn,"SELECT * FROM kategori order by id DESC");
                       while($var=mysqli_fetch_array($query)){
                        ?>
                        <tr>
                          <td><?php echo $no++; ?></td>
                          <td><a href="?page=topic&cat_id=<?php echo $var['id'] ?>" class="text-dark"><?php echo $var['judul'] ?></a></td>
                          <td><?php echo $var['detail'] ?></td>
                        </tr>
                        <?php
                       }
                        ?>
                     </tbody>
                   </table>
                 </pre>
               </div>
             </div>
           </div>
           <div class="col-md-4 mt-4 col-12 col-sm-12">
             <div class="card border border-dark">
               <div class="card-body">
                 <?php if(!@$_SESSION['login']){ ?>
                   <h3 class="text-center">Login</h3><hr>
                   <form class="" action="" method="post">
                     <div class="form-group">
                       <label for="username">Email</label>
                       <input type="text" name="email" value="" placeholder="Email..." class="form-control" id="username" required>
                     </div>
                     <div class="form-group">
                       <label for="password">Password</label>
                       <input type="password" name="password" value="" placeholder="Password..." class="form-control" id="password" required>
                     </div>
                     <input type="submit" name="submit" value="Login" class="btn btn-secondary">
                     <a href="?menu=register" class="btn btn-primary">Register</a>
                   </form>
                 <?php
                   if ($_POST['submit']) {
                     $email=sql($_POST['email']);
                     $password=md5($_POST['password']);
                     $q_login=mysqli_query($conn,"SELECT * FROM pengguna where email='$email' AND password='$password'");
                     if (mysqli_num_rows($q_login)===1) {
                       $vari=mysqli_fetch_array($q_login);
                       $_SESSION['login']=$email;
                       $_SESSION['username']=$vari['level'];
                       $_SESSION['id_user']=$vari['id_user'];
                       $_SESSION['name_user']=$vari["username"];
                       header("location: index.php");
                     }else{
                       echo "<div class='alert alert-warning mt-3'>Gagal login!</div>";
                     }
                  }
               }else{
                 ?>
                 <div class="card">
                   <div class="card-body">
                     <strong>
                       News topic:
                     </strong>
                     <hr>
                     <ul>
                       <?php
                       $q_var_view=mysqli_query($conn, "SELECT * FROM topik ORDER BY id DESC LIMIT 0, 5");
                       while($var_view=mysqli_fetch_array($q_var_view)){
                         echo "<li><a class='text-dark' href='?page=topic&cat_id=".$var_view['id_kategori']."&view=".$var_view['id']."'>".$var_view['judul']."</li>";
                       }
                        ?>
                     </ul>
                   </div>
                 </div>
                 <?php
               }
                ?>

               </div>
             </div>
           </div>
         </div>
       <?php }elseif($_GET['menu']=="register"){ ?>
         <?php $retitle=$forum_name." | Register"; ?>
         <div class="card mt-3 border border-dark">
           <div class="card-body">
             <h2 class="text-center">Register</h2>
             <hr><br>
             <form class="" action="?menu=register" method="post" enctype="multipart/form-data">
               <div class="form-group row">
                 <label for="username" class="col-md-2">Username : </label>
                 <input type="text" name="username" value="" placeholder="Username..." class="form-control col-md-10" min="5" required>
               </div>
               <div class="form-group row">
                 <label for="gambar" class="col-md-2">Photo : </label>
                 <input type="file" name="gambar" value="" class="col-md-10">
               </div>
               <div class="form-group row">
                 <label for="email" class="col-md-2">Email:</label>
                 <div class="col-md-10">
                   <div class="input-group">
                     <div class="input-group-prepend">
                       <div class="input-group-text">@</div>
                     </div>
                     <input type="email" class="form-control" id="inlineFormInputGroupUsername" placeholder="Email..." name="email" required>
                   </div>
                 </div>
               </div>
               <div class="form-group row">
                 <label for="password" class="col-md-2">Password :</label>
                 <input type="password" name="password" min="5" value="" placeholder="Password..." class="form-control col-md-10" required>
               </div>
               <input type="submit" name="submit_register" value="Register" class="btn btn-primary">
             </form>
             <?php
             if ($_POST['submit_register']) {
               $username=sql_xss($_POST['username']);
               $password=md5($_POST['password']);
               $email=sql($_POST['email']);
               $date=date("Y-m-d H:i:s");
               $extensi=sql($_FILES['gambar']['name']);
               $extensi="img_user/".basename($extensi);
               $extensi=pathinfo($extensi,PATHINFO_EXTENSION);


               $level_digantiIdUser=uniqid()."--p3m1s4h--".$username;
               $tmp_g=$_FILES['gambar']['tmp_name'];
               $tempat_g=$level_digantiIdUser.".".$extensi;


               //validasi email
               $q_validasi_email=mysqli_query($conn,"SELECT * FROM pengguna where email='$email'");
               $q_validasi_email=mysqli_num_rows($q_validasi_email);


               if($_POST['email']==true && $_POST['password']==true && $_POST['username']==true){
                 // echo "<script>alert('".$extensi."')</script>";
                 if($q_validasi_email===0){
                   $q_validasiUsername=mysqli_query($conn,"SELECT * FROM pengguna where username='$username'");
                   $q_validasiUsername=mysqli_num_rows($q_validasiUsername);
                   if($q_validasiUsername===0){
                     if ($extensi=="jpg"||$extensi=="png"||$extensi=="JPEG"||$extensi=="PNG"||$extensi=="jpeg"||$extensi=="JPG") {
                       move_uploaded_file($tmp_g,"img_user/".$tempat_g);
                       $nama_file=$tempat_g;
                         if (mysqli_query($conn,"INSERT INTO pengguna(username,email,password,foto,tgl_daftar,level,total,status) VALUES('$username','$email','$password','$nama_file','$date','$level_digantiIdUser','0','aktif')")) {
                           echo "<br><div class='alert alert-success'>Berhasil register, <a href='?menu=login'>Login</a>.</div>";
                         }else{
                           echo "<div class='alert alert-danger'>Cek config!</div>";
                         }
                     }else{
                       $nama_file="default.jpg";
                       // if(mail($email,$subject,$massage,$header)){
                         if (mysqli_query($conn,"INSERT INTO pengguna(username,email,password,foto,tgl_daftar,level,total,status) VALUES('$username','$email','$password','$nama_file','$date','$level_digantiIdUser','0','aktif')")) {
                           echo "<br><div class='alert alert-success'>Berhasil register, <a href='?menu=login'>Login</a>.</div>";
                         }else{
                           echo "<br><div class='alert alert-danger'>Cek config!</div>";
                         }
                       // }else {
                       //   echo "<br><div class='alert alert-danger'>Gagal kirim verif email</div>";
                       // }
                     }
                   }else{
                     echo "<div class='alert alert-warning mt-3'>Mohon maaf <strong>'Username'</strong> sudah digunakan, silahkan coba username lain.</div>";
                   }
                 }else{
                   echo "<div class='mt-3 alert alert-warning'>Mohon maaf <strong>'email'</strong> sudah digunakan, silahkan coba email lain.</div>";
                 }
               }else{
                 echo "<div class='alert alert-warning mt-3'>Salah satu form <strong>username,email,password</strong> tidak boleh kosong!</div>";
               }
             }
              ?>
           </div>
         </div>
       <?php }elseif($_GET['menu']=="login"){ ?>
         <?php $retitle=$forum_name." | Login"; ?>
         <div class="card border border-dark mt-3">
           <div class="card-body">
             <h2 class="text-center">Login</h2>
             <hr><br>
             <form class="" action="?menu=login" method="post">
                 <div class="input-group mb-2">
                   <div class="input-group-prepend">
                     <div class="input-group-text">Email</div>
                   </div>
                   <input type="text" class="form-control" id="inlineFormInputGroup" name="email" placeholder="Email...">
                 </div>
                 <div class="input-group mb-2">
                   <div class="input-group-prepend">
                     <div class="input-group-text">Password</div>
                   </div>
                   <input type="password" class="form-control" id="inlineFormInputGroup" name="password" placeholder="Password...">
                 </div>
                 <input type="submit" name="submit_login" value="Login" class="btn btn-primary">
                 <a href="?menu=register" class="btn btn-secondary">Register</a>
             </form>

             <?php
             if ($_POST['submit_login']) {
               $email=sql($_POST['email']);
               $password=md5($_POST['password']);
               $q=mysqli_query($conn,"SELECT * FROM pengguna where email='$email' AND password='$password'");
               if (mysqli_num_rows($q)===1) {
                 $vari=mysqli_fetch_array($q);
                 if($vari['level']=="not_actived"){
                   ?>
                   <br>
                   <div class="alert alert-danger">
                     Email belum di konfirmasi, silahkan cek email segera!
                   </div>
                   <?php
                 }else{
                   $_SESSION['login']=$email;
                   $_SESSION['username']=$vari['level'];
                   $_SESSION['id_user']=$vari['id_user'];
                   $_SESSION['name_user']=$vari['username'];
                   header("location: index.php");
                 }
               }else{
                 echo "<br><div class='alert alert-warning'>Gagal login!</div>";
               }
             }
              ?>
           </div>
         </div>
       <?php
       } elseif ($_GET['page']=="topic") {
         if ($_GET['cat_id']) {
           $cat_id=sql($_GET['cat_id']);
           $view_id=mysqli_query($conn,"SELECT * FROM kategori where id='$cat_id'");
           $var=mysqli_fetch_array($view_id);
           $cocok_id=mysqli_num_rows($view_id);
           if ($cocok_id!==1) {
             $retitle=$forum_name." | 404 Pages Not Found";
             page_404();
           }else{
             $q_cekKategoriTerisi=mysqli_query($conn,"SELECT * FROM topik where id_kategori='$cat_id'");
             $q_cekKategoriTerisi=mysqli_num_rows($q_cekKategoriTerisi);
             if ($q_cekKategoriTerisi==0) {
               $retitle=$forum_name." | Topic - ".$var['judul'];
               ?>
               <div class="card border-dark mt-3">
                 <div class="card-body">
                   <h4 style="padding: 20px">
                     The topics in this category are still empty. Are you willing to fill in? (<a class="text-dark" href="?add=<?php echo $cat_id; ?>"><u> Click here for yes </u></a>).
                     <br><br>
                   </h4>
                   <?php if(!@$_SESSION['login']){ ?>
                     <div class="text-muted text-center">
                       You are not logged in, Please login first to access the <strong>"Add Topic"</strong> page. <hr style="width: 350px">
                     </div>
                   <?php } ?>
                 </div>
               </div>
               <?php
             }else{
             // echo "<script>alert(".$q_cekKategoriTerisi.")</script>";
             $retitle=$forum_name." | Topic - ".$var['judul'];
           ?>

           <!-- ?page=topic&cat_id=id -->

           <div class="card border border-dark mt-3">
             <div class="card-body">

               <?php if ($_GET['cat_id'] && !$_GET['view']){ ?>
               <?php if(@$_SESSION['login']){ ?><a href="?add=<?php echo $cat_id; ?>" class="btn btn-dark mt-3 col-md-12">Add topic, Category <?php echo $var['judul'] ?></a><?php } ?>
               <pre>
                 <table class="table table-hover">
                   <thead>
                     <tr>
                       <th width="10px">No</th>
                       <th width="300px">Topic From, <?php echo $var['judul'] ?></th>
                       <th width="200px">Date</th>
                     </tr>
                   </thead>
                   <tbody>
                     <?php
                     //q baru
                     // $cat_id=sql($_GET['cat_id']);
                     $hal_pagging="10";
                     $paging=isset($_GET['pg'])?(int)$_GET["pg"]:1;
                     $mulai_page=($paging>1)?($paging * $hal_pagging)-$hal_pagging:0;
                     $topik_query=mysqli_query($conn, "SELECT * FROM topik WHERE id_kategori='$cat_id' ORDER BY id DESC LIMIT $mulai_page, $hal_pagging");
                     $cek_total_topik=mysqli_query($conn, "SELECT * FROM topik where id_kategori='$cat_id'");
                     $total_row=mysqli_num_rows($cek_total_topik);
                     $pages_paging=ceil($total_row/$hal_pagging);


                     $q_cekIdKategori=mysqli_query($conn,"SELECT * FROM topik where id_kategori='$cat_id'");
                     ?>
                     <?php
                     $no=1;
                       while ($var=mysqli_fetch_array($topik_query)) {
                      ?>
                      <tr>
                        <td><?php echo $no++; ?></td>
                        <td><a class="text-dark" href="?page=topic&cat_id=<?php echo $_GET['cat_id'] ?>&view=<?php echo $var['id'] ?>"><?php echo $var['judul'] ?></a></td>
                        <td><?php echo $var['tgl'] ?></td>
                      </tr>
                      <?php
                       }
                      ?>
                   </tbody>
                 </table>
               </pre>
             <?php if(mysqli_num_rows($q_cekIdKategori)>10){ ?>
                 <nav aria-label="...">
                   <ul class="pagination pagination-sm">
                      <?php for($i=1;$i<=$pages_paging;$i++){ ?>
                          <li class="page-item"><a class="page-link" href="?page=topic&cat_id=<?php echo $_GET['cat_id']; ?>&pg=<?php echo $i; ?>"><?php echo $i ?></a></li>
                      <?php } ?>
                   </ul>
                 </nav>
              <?php } ?>
               <!-- ?page=topic&cat_id=id&view=id -->
               <?php
               if ($_GET['menu']=="delete_topik") {
                 $retitle=$forum_name." | Delete topik";

                 $id=sql($_GET['id']);
                 $q_cek_user_delete=mysqli_query($conn,"SELECT * FROM topik where id='$id' AND username='$_SESSION[username]'");

                   if ($_GET['id']) {
                     if(mysqli_num_rows($q_cek_user_delete)===1){
                       $q="SELECT * FROM topik where id='$id'";
                       $q=mysqli_query($conn,$q);
                       if (mysqli_num_rows($q)===1) {
                         $q_delete_topik="DELETE FROM topik where id='$id'";
                         if (mysqli_query($conn,$q_delete_topik)) {
                           echo "<div class='alert alert-success'>Topic deleted successfully!</div>";
                         }else{
                           echo "<script>alert('Ups, sistem bermasalah!')</script>";
                         }
                       }else{
                         page_404();
                       }
                     }else {
                       header("location: ?page=topic&cat_id=$cat_id");
                     }
                   }else{
                     page_404();
                   }
               }
                ?>
               <?php
                }
               elseif ($_GET['view']) {
                 $view_id_topik=sql($_GET['view']);
                 $q_viewIdTopic=mysqli_query($conn,"SELECT * FROM topik where id='$view_id_topik'");
                 if (mysqli_num_rows($q_viewIdTopic)===1) {
                   $id_kategori=sql($_GET['cat_id']);
                   $query_topic_catid_view=mysqli_query($conn,"SELECT * FROM topik where id='$view_id_topik'");
                   $query_topic_catid_view=mysqli_fetch_array($query_topic_catid_view);
                   $retitle.=" - ".$query_topic_catid_view['judul'];
                   $exp_penerbit=explode("--p3m1s4h--",$query_topic_catid_view['username']);

                   ?>
                   <h1 class="text-center"><?php echo $query_topic_catid_view['judul']; ?></h1>
                   <hr style="border-top: 2px solid #666; ">
                   Category <a href="?page=topic&cat_id=<?php echo $_GET['cat_id']; ?>" class="text-secondary"><?php echo xss($var['judul']); ?></a> By, <a href="?page=profile&user=<?php echo $query_topic_catid_view['username']; ?>"><?php echo xss($exp_penerbit['1']); ?></a> (<?php echo $query_topic_catid_view['tgl']; ?>)
                    <?php
                    if (@$_SESSION['username']===$query_topic_catid_view['username']) {
                    ?>
                    <br><br>
                      <a href="?menu=edit_topik&id=<?php echo $view_id_topik ?>" class="btn btn-secondary">Edit</a>
                      <a href="?page=topic&cat_id=<?php echo $id_kategori ?>&menu=delete_topik&id=<?php echo $view_id_topik ?>" class="btn btn-secondary">Delete</a>
                    <?php
                    }
                    ?>
                   <hr style="border-top: 2px solid #666; ">
                   <p><?php echo $query_topic_catid_view['detail'] ?></p>
                   <?php
                   if (!$_SESSION['login']) {
                     echo "<div class='text-center mt-3'>You Need Login For Access</div>";
                   }else{
                     ?>
                     <div class="card mt-5 border-dark">
                       <div class="card-body">
                         <h3 class="">Reply:</h3><hr>
                         <div class="row">
                           <div class="col-md-6 mt-3">
                             <?php
                             // $id_replyne=sql($_GET[''])
                             $reply_pagging="5";
                             $paging_reply=isset($_GET['pg_r'])?(int)$_GET["pg_r"]:1;
                             $mulai_reply=($paging_reply>1)?($paging_reply * $reply_pagging)-$reply_pagging:0;
                             $query_reply=mysqli_query($conn, "SELECT * FROM reply WHERE id_topik='$view_id_topik' ORDER BY id DESC LIMIT $mulai_reply, $reply_pagging");
                             $cek_total_reply=mysqli_query($conn, "SELECT * FROM reply WHERE id_topik='$view_id_topik'");
                             $total_row_reply=mysqli_num_rows($cek_total_reply);
                             $pages_paging=ceil($total_row_reply/$reply_pagging);

                             // $q_viewReply=mysqli_query($conn,"SELECT * FROM reply where id_topik='$view_id_topik' order by id DESC");
                             while ($a=mysqli_fetch_array($query_reply)) {
                               // $exp_foto_user=explode("----pemisah----",$a['username']);
                               $exp_usernname_user=explode("--p3m1s4h--",$a['username']);
                               ?>
                               <hr>
                               <!-- <strong><?php //echo $exp_usernname_user['1']; ?></strong> -->
                               <div class="row">
                                 <div class="col-md-4">
                                   <a href="?profile=<?php echo $a['username'] ?>" class="text-dark">
                                      <strong>Name: <?php echo $exp_usernname_user['1'] ?></strong>
                                   </a>
                                 </div>
                                 <div class="col-md-8">
                                   <p style="word-wrap: break-word;">
                                     <strong>Reply:</strong> <?php echo $a['reply'] ?>
                                     <br>
                                     <strong>Time:</strong> <?php echo $a['tgl'] ?>
                                   </p>
                                 </div>
                               </div>
                               <?php
                             }
                             // print_r($exp_foto_user);
                             echo "<hr>";
                             echo '
                             <nav aria-label="...">
                               <ul class="pagination pagination-sm">

                             ';
                             for ($i_r=1; $i_r <= $pages_paging; $i_r++) {
                               echo '
                               <li class="page-item"><a class="page-link" href="?page=topic&cat_id='.$id_kategori.'&view='.$view_id_topik.'&pg_r='.$i_r.'">'.$i_r.'</a></li>
                               ';
                             }
                             echo "
                               </ul>
                             </nav>
                             ";
                             //////////////////////////////////////////////////////////////iki
                              ?>
                           </div>
                           <div class="col-md-6 mt-3">
                             <form class="" method="post">
                               <label for="komen"> <strong>Added reply</strong> </label>
                               <textarea name="komen" id=komen rows="8" cols="80" class="form-control" placeholder="Reply..."></textarea>
                               <input type="submit" name="submit_reply" value="Submit reply" class="btn btn-primary mt-3 col-md-12">
                             </form>
                             <?php

                             //view extensi foto
                             $email_ext=$_SESSION['login'];
                             $view_gambar=mysqli_query($conn,"SELECT * FROM pengguna where email='$email_ext'");
                             $view_gambar=mysqli_fetch_array($view_gambar);

                             $username=$_SESSION['username'];
                             $reply=sql_xss($_POST['komen']);
                             $tgl=date("Y-m-d H:i:s");
                             $id_topik=sql($_GET['view']);



                             $q_insertReply="INSERT INTO reply(username,reply,tgl,id_topik) values('$username','$reply','$tgl','$id_topik')";
                             if($_POST['submit_reply']){
                               // echo "<script>alert('".$username."')</script>";
                               if($_POST['komen']){
                                 if (mysqli_query($conn,$q_insertReply)) {
                                   echo "<div class='alert alert-success mt-3'>Successfully added reply.</div>";
                                 }else {
                                   echo "<div class='alert alert-warning mt-3'>Cek config!</div>";
                                 }
                               }else {
                                 echo "<div class='alert alert-warning mt-3'>Replies cannot be empty!</div>";
                               }
                             }
                              ?>
                           </div>
                         </div>
                       </div>
                     </div>
                     <?php
                   }
                    ?>
                   <?php
                 }else{
                   $retitle=$forum_name." | Topic Not found";
                   header_404();
                 }
               }
                ?>
             </div>
           </div>
           <?php
            }
          }
         }else {
           $retitle=$forum_name." | 404 Pages Not Found";
           page_404();
         }
       }elseif ($_GET['menu']=="disclaimer") {
         $retitle=$forum_name." | Disclaimer";
         ?>
         <!-- <span class="border border-danger"></span> -->
         <h1 class="border border-danger rounded text-center mt-3" style="padding: 20px;">Disclaimer</h1>
         <div class="card border border-danger">
           <div class="card-body text-center">
              We Are Not Responsible For Whatever Happens.
           </div>
         </div>
         <br><br><br><br><br>
         <?php
       }elseif ($_GET['menu']=="about") {
         $retitle=$forum_name." | About";
         ?>
         <div class="card border border-dark mt-3">
           <div class="card-body text-center">
             <h1>Hacker Forum</h1>
              This A Hacker Forum
           </div>
         </div>
         <br><br><br><br>
         <?php
       }elseif ($_GET['menu']=="tambah_topik") {
         if (!$_SESSION['login']) {
           header("location: ?menu=login");
           exit;
         }
         $retitle=$forum_name." | "."Add Topic";
         ?>
         <div class="card border-dark mt-3">
           <div class="card-body">
             <h2 class="text-center">Add topic</h2><hr>
             <form class="mt-4" action="?menu=tambah_topik" method="post">
               <div class="row">
                 <div class="col-md-4">
                   <label id="topik">
                     <strong>Topic :</strong>
                   </label>
                 </div>
                 <div class="col-md-8">
                   <input type="text" name="topic" value="" placeholder="Topic..." id="topik" class="form-control" required>
                 </div>
               </div>
               <div class="row mt-3">
                 <div class="col-md-4">
                   <label id="topik">
                     <strong>Category :</strong>
                   </label>
                 </div>
                 <div class="col-md-8">
                   <select class="form-control" name="kategori" required>
                     <option value="">Category...</option>
                     <?php
                     $q_selectKategori=mysqli_query($conn,"SELECT * FROM kategori");
                     while ($var=mysqli_fetch_array($q_selectKategori)) {
                       echo "<option value='".$var['id']."'>".$var['judul']."</option>";
                     }
                      ?>
                   </select>
                 </div>
               </div>
               <div class="row mt-3">
                 <div class="col-md-4">
                   <label id="topik">
                     <strong>Detail :</strong>
                   </label>
                 </div>
                 <div class="col-md-8">
                   <textarea name="detail" rows="8" cols="80" placeholder="Detail..." class="form-control" required></textarea>
                 </div>
               </div>
               <input type="submit" name="submit" value="Submit" class="btn btn-primary col-md-12 mt-3">
             </form>
              <a href="?menu=tambah_kategori" class="btn btn-secondary mt-3 col-md-12">Add Category Topic</a>
              <?php
              if ($_POST['submit']) {
                echo "<br>";
                $judul=sql_xss($_POST['topic']);
                $detail=sql_xss($_POST['detail']);
                $tgl=date("Y-m-d H:i:s");
                $username=$_SESSION['username'];
                $id_kategori=sql_xss($_POST["kategori"]);
                $q="INSERT INTO topik(judul,detail,id_kategori,tgl,username) values('$judul','$detail','$id_kategori','$tgl','$username')";

                if (mysqli_query($conn,$q)) {
                  echo "<div class='mt-3 alert alert-success'>Topic added successfully!</div>";
                }else{
                  echo "<div class='mt-3 alert alert-warning'>Ups system sedang bermasalah, silahkan hubungi administrator.</div>";
                }

              }
              ?>
           </div>
         </div>
         <?php

       }elseif($_GET['menu']=="tambah_kategori"){
         if (!$_SESSION['login']) {
           header("location: ?menu=login");
           exit;
         }
         $retitle=$forum_name." | Add Category";
         ?>
         <div class="card border-dark mt-3">
           <div class="card-body">
             <h2 class="text-center">Add Category Topic</h2><hr>
             <form class="mt-4" action="?menu=tambah_kategori" method="post">
               <div class="row">
                 <div class="col-md-4">
                   <strong>Category:</strong>
                 </div>
                 <div class="col-md-8">
                   <input type="text" name="kategori" value="" placeholder="Category..." class="form-control">
                 </div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-4">
                    <strong>Detail:</strong>
                  </div>
                  <div class="col-md-8">
                    <input type="text" name="detail" value="" placeholder="Detail..." class="form-control">
                  </div>
                 </div>
               <input type="submit" name="submit" value="Submit" class="btn btn-primary btn-sm mt-3 col-md-12">
             </form>
             <?php
             if ($_POST['submit']) {
               $judul=sql_xss($_POST['kategori']);
               $detail=sql_xss($_POST['detail']);
               $q="INSERT INTO kategori(judul,detail) values('$judul','$detail')";
               if (mysqli_query($conn,$q)) {
                 echo "<div class='mt-3 alert alert-success'>Success category added!</div>";
               }else{
                 echo "<div class='alert alert-danger'>Cek config!</div>";
               }
             }
              ?>
           </div>
         </div>
         <?php
       }elseif ($_GET['add']) {
         $id=sql($_GET['add']);
         $q_cekKategori=mysqli_query($conn,"SELECT * FROM kategori where id='$id'");
         $q_cekKategori=mysqli_num_rows($q_cekKategori);
         if ($q_cekKategori===0) {
           $retitle=$forum_name." | 404 Pages Not Found";
           page_404();
         }else{
           if (!$_SESSION['login']) {
             header("location: ?menu=login");
             exit;
           }else{
             $var=mysqli_query($conn,"SELECT * FROM kategori where id='$id'");
             $var=mysqli_fetch_array($var);
             $retitle=$forum_name." | Add topic - ".$var['judul'];
             ?>
             <div class="card border-dark mt-3">
               <div class="card-body">
                 <h3 class="text-center">Add topic <i><?php echo $var['judul']; ?></i></h3><hr>
                 <form class="mt-4" action="?add=<?php echo $id ?>" method="post">
                   <div class="row">
                     <div class="col-md-4">
                       <label id="judul"><strong>Title:</strong></label>
                     </div>
                     <div class="col-md-8">
                       <input type="text" name="judul" value="" placeholder="Topic title..." id="judul" class="form-control">
                     </div>
                   </div>
                   <div class="row mt-3">
                     <div class="col-md-4">
                       <label id="kategori"><strong>Detail:</strong></label>
                     </div>
                     <div class="col-md-8">
                       <textarea name="detail" rows="8" cols="80" placeholder="Detail..." class="form-control"></textarea>
                     </div>
                   </div>
                   <input type="submit" name="submit" value="Submit" class="btn btn-primary col-md-12 mt-3">
                 </form>
                 <?php
                 if ($_POST['submit']) {
                   $judul=sql_xss($_POST['judul']);
                   $detail=sql_xss($_POST['detail']);
                   $tgl=date("Y-m-d H:i:s");
                   $username=$_SESSION['username'];
                   $q_submitTambah="INSERT INTO topik(judul,detail,id_kategori,tgl,username) values('$judul','$detail','$id','$tgl','$username')";
                   if (mysqli_query($conn,$q_submitTambah)) {
                     echo "<div class='mt-3 alert alert-success'>Success in adding data.</div>";
                   }else {
                     echo "<div class='mt-3 alert alert-warning'>Cek config!</div>";
                   }
                 }
                  ?>
               </div>
             </div>
             <?php
           }
         }
       }elseif ($_GET['menu']=="edit_topik") {
         if ($_GET['id']) {
           $username=$_SESSION['username'];
           $id=sql($_GET['id']);
           $q_cekSessionUser=mysqli_query($conn,"SELECT * FROM topik where username='$username' AND id='$id'");
           $q_outputTopik=mysqli_fetch_array($q_cekSessionUser);
           $q_cekSessionUser=mysqli_num_rows($q_cekSessionUser);
           // echo "<script>alert('".$q_cekSessionUser."')</script>";
           if ($q_cekSessionUser===1) {
             $retitle=$forum_name." | Edit topic - ".$q_outputTopik['judul'];
             ?>
             <div class="card border-dark mt-3">
               <div class="card-body">
                 <h2 class="text-center">Edit topic <?php echo $q_outputTopik['judul'] ?></h2><hr>
                 <form class="mt-4" method="post">
                   <div class="row">
                     <div class="col-md-4">
                       <label for="judul"> <strong>Judul:</strong> </label>
                     </div>
                     <div class="col-md-8">
                       <input id="judul" type="text" name="judul" placeholder="Title topic" value="<?php echo $q_outputTopik['judul'] ?>" class="form-control">
                     </div>
                   </div>
                   <div class="row mt-3">
                     <div class="col-md-4">
                       <label for="detail"> <strong>Detail:</strong> </label>
                     </div>
                     <div class="col-md-8">
                       <textarea name="detail" rows="8" cols="80" placeholder="Detail" class="form-control"> <?php echo $q_outputTopik['detail'] ?></textarea>
                     </div>
                   </div>
                   <input type="submit" name="submit" value="Edit" class="btn btn-primary col-md-12 mt-3">
                 </form>
                 <?php
                 if ($_POST['submit']) {
                   $judul=sql_xss($_POST['judul']);
                   $detail=sql_xss($_POST['detail']);
                   $username=$_SESSION['username'];
                   $tgl=date("Y-m-d H:i:s");
                   $id_kategori=sql($_GET['id']);
                   if ($judul==true && $detail==true) {
                     $q_updateTopik="UPDATE topik SET judul='$judul',detail='$detail',tgl='$tgl',username='$username' where id='$id_kategori'";
                     if (mysqli_query($conn,$q_updateTopik)) {
                       echo "<div class='alert alert-success mt-3'>Topic edited successfully!</div>";
                     }else {
                       echo "<div class='alert alert-warning mt-3'>Cek config!</div>";
                     }
                   }
                 }
                  ?>
               </div>
             </div>
             <?php
           }else{
             $retitle=$forum_name." | 404 Page not found";
             page_404();
           }
         }else{
           $retitle=$forum_name." | 404 Page not found";
           page_404();
         }
       }elseif ($_GET['page']=="profile") {
         if($_SESSION['login']){
           // if ($_GET['user']) {
             // $user_profile=sql($_GET['user']);
             $user_profile=$_SESSION['id_user'];
             $q=mysqli_query($conn,"SELECT * FROM pengguna where id_user='$user_profile'");
             // echo "<script>alert('$user_profile')</script>";
             if (mysqli_num_rows($q)===1) {
               $var=mysqli_fetch_array($q);
               $retitle=$forum_name." | Profile ".$var['username'];
               ?>
               <div class="card border-dark mt-3">
                 <div class="card-body">
                   <h1 class="text-center">Profile</h1>
                   <hr>
                   <div class="row mt-4">
                     <div class="col-md-4 d-flex justify-content-center">
                       <img src="img_user/<?php echo $var['foto'] ?>" alt="Pict..." style="width: 300px;height: auto;object-fit: cover;object-position: center;" class="img-fluid">
                     </div>
                     <div class="col-md-8">
                               <h2>
                                         Name:
                                         <u class=""><?php echo $var['username'] ?></u>
                                   <br>
                                         Tanggal daftar:
                                         <u><?php echo $var['tgl_daftar'] ?></u>
                                         <br>
                                         Status:
                                         <u><?php echo $var['status']; ?></u>
                                         <br>
                                         Email: <u><?php echo $var['email']; ?></u>
                                         <br>
                                         <a href="?menu=edit_profile" class="btn btn-secondary col-md-12 mt-3">Edit Profile</a>
                               </h2>
                     </div>
                   </div>
                 </div>
               </div>
               <?php
             }else {
               $retitle=$forum_name." | Profile not found";
               echo "
               <div class='card border-dark mt-3'>
                  <div class='card-body'>
                      <h1 class='text-center' style='padding: 20px'>Profile not found!</h1>
                  </div>
               </div>
               ";
             }


           // }else{
           //     $retitle=$forum_name." | 404 Page not found";
           //   page_404();
           // }
         }else{
             $retitle=$forum_name." | 404 Page not found";
           page_404();
         }
     }elseif ($_GET['menu']==="edit_profile") {
         if ($_SESSION['login']) {
             $user_profile=$_SESSION['id_user'];
             $q=mysqli_query($conn,"SELECT * FROM pengguna where id_user='$user_profile'");
             if (mysqli_num_rows($q)===1) {
                 $var=mysqli_fetch_array($q);
                 $retitle=$forum_name." | Profile ".$var['username'];
                 ?>
                 <div class="card border-dark mt-3">
                     <div class="card-body">
                         <h2 class="text-center">Update Profile</h2>
                         <hr>
                         <form enctype="multipart/form-data" method="post">
                             <div class="row">
                                 <div class="col-md-2 mt-1">
                                     Email
                                 </div>
                                 <div class="col-md-10">
                                     <input type="text" value="<?php echo $var['email'] ?>" placeholder="Email..." class="form-control" style="cursor: not-allowed;" readonly>
                                 </div>
                             </div>
                             <div class="row mt-3">
                                 <div class="col-md-2 mt-1">
                                     Password
                                 </div>
                                 <div class="col-md-10">
                                     <input type="text" name="password" value="" placeholder="Password..." class="form-control">
                                 </div>
                             </div>
                             <div class="row mt-3">
                                 <div class="col-md-2 mt-1">
                                     Gambar
                                 </div>
                                 <div class="col-md-10">
                                     <input type="file" name="gambar" class="form-control">
                                 </div>
                             </div>
                             <input type="submit" name="submit_update" value="Update Profile" class="col-md-12 btn btn-secondary text-center mt-3">
                         </form>
                         <?php

                         if ($_POST['submit_update']) {
                             if ($_POST['password']) {
                               $username=$_SESSION['name_user'];
                               $password=md5($_POST['password']);
                               $email=sql($_POST['email']);
                               $date=date("Y-m-d H:i:s");
                               $extensi=sql($_FILES['gambar']['name']);
                               $extensi="img_user/".basename($extensi);
                               $extensi=pathinfo($extensi,PATHINFO_EXTENSION);


                               $level_digantiIdUser=uniqid()."--p3m1s4h--".$username;
                               $tmp_g=$_FILES['gambar']['tmp_name'];
                               $tempat_g=$level_digantiIdUser.".".$extensi;

                               $id_user=$_SESSION['id_user'];

                                   $q_cekfoto=mysqli_query($conn,"SELECT * FROM pengguna where id_user='$id_user'");
                                   $q_cekfoto=mysqli_fetch_array($q_cekfoto);
                                   if ($q_cekfoto['foto']==="default.jpg") {
                                       if ($extensi=="jpg"||$extensi=="png"||$extensi=="JPEG"||$extensi=="PNG"||$extensi=="jpeg"||$extensi=="JPG") {
                                           $q_foto=mysqli_query($conn,"SELECT * FROM pengguna where id_user=$id_user");
                                           $q_foto=mysqli_fetch_array($q_foto);
                                           move_uploaded_file($tmp_g,"img_user/".$tempat_g);
                                           $nama_file=$tempat_g;
                                               if (mysqli_query($conn,"UPDATE pengguna set password='$password', foto='$nama_file' where id_user='$id_user'")) {
                                                   echo "<br><div class='alert alert-success'>Update success</div>";
                                               }else{
                                                   echo "<div class='alert alert-danger mt-3'>Cek config!</div>";
                                               }
                                       }else{
                                           $nama_file="default.jpg";
                                           if (mysqli_query($conn,"UPDATE pengguna set password='$password', foto='$nama_file' where id_user='$id_user'")) {
                                               echo "<br><div class='alert alert-success'>Update success</div>";
                                           }else{
                                               echo "<br><div class='alert alert-danger'>Cek config!</div>";
                                           }
                                       }
                                   }else {
                                       if ($extensi=="jpg"||$extensi=="png"||$extensi=="JPEG"||$extensi=="PNG"||$extensi=="jpeg"||$extensi=="JPG") {
                                           $q_foto=mysqli_query($conn,"SELECT * FROM pengguna where id_user='$id_user'");
                                           $q_foto=mysqli_fetch_array($q_foto);
                                           move_uploaded_file($tmp_g,"img_user/".$tempat_g);
                                           $nama_file=$tempat_g;
                                           $qiwok=$q_foto['foto'];
                                           // echo "<script>alert('$qiwok')</script>";

                                           if (unlink("img_user/".$q_foto['foto'])) {
                                               if (mysqli_query($conn,"UPDATE pengguna set password='$password', foto='$nama_file' where id_user='$id_user'")) {
                                                   echo "<br><div class='alert alert-success'>Update success</div>";
                                               }else{
                                                   echo "<div class='alert alert-danger'>Cek config!</div>";
                                               }
                                           }else {
                                               echo "<div class='alert alert-danger'>Gagal Update!</div>";
                                           }
                                       }else{
                                           $q_foto=mysqli_query($conn,"SELECT * FROM pengguna where id_user='$id_user'");
                                           $q_foto=mysqli_fetch_array($q_foto);
                                           $nama_file="default.jpg";
                                           // if(mail($email,$subject,$massage,$header)){
                                           if (unlink("img_user/".$q_foto['foto'])) {
                                               if (mysqli_query($conn,"UPDATE pengguna set password='$password', foto='$nama_file' where id_user='$id_user'")) {
                                                   echo "<br><div class='alert alert-success'>Update success</div>";
                                               }else{
                                                   echo "<br><div class='alert alert-danger'>Cek config!</div>";
                                               }
                                           }else {
                                               echo "<div class='alert alert-danger'>Gagal Update!</div>";
                                           }
                                       }
                                   }
                               }else {
                                   echo "<div class='alert alert-warning mt-3'>Harap isi password!</div>";
                               }
                         }

                          ?>
                     </div>
                 </div>
                 <?php
             }else {
                 $retitle=$forum_name." | Profile not found";
                 echo "
                 <div class='card border-dark mt-3'>
                    <div class='card-body'>
                        <h1 class='text-center' style='padding: 20px'>Profile not found!</h1>
                    </div>
                 </div>
                 ";
             }
         }else {
             $retitle=$forum_name." | 404 Page not found";
             page_404();
         }
     }elseif ($_GET['menu']=="logout") {
       session_destroy();
       header("location:index.php");
     }else {
         page_404();
     }

       /////////////////////edit topic,delete topic,komentar topic,chat.......

       //////////pembnenahan --pemisah--
        ?>
     </div>
     <!-- end home -->



     <!-- footer -->
     <br><br><br><br><br>
     <footer class=" bg-dark text-center text-white mt-5" style="padding: 20px;">
       Copyright &copy;2020
     </footer>
     <!-- end footer -->

     <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

     <script>
     $("ul > li").hover(
         function() {
             $(this).addClass('active');
         }, function() {
             $(this).removeClass('active');
         }
     );
     $( "ul > li" ).click(function(){
             $(this).toggleClass('active');
     });

     $(".js").hover(
       function() {
         $(this).addClass("bg-primary");
       }, function() {
         $(this).removeClass("bg-primary");
       }
     );
     </script>
   </body>
 </html>
<?php
if (!empty($retitle)) {
  $ob_content=ob_get_contents();
  ob_end_clean();
  echo str_replace("<!-- sub -->",$retitle,$ob_content);
  // exit;
}
 ?>

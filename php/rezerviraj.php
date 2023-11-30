<?php
    $id = $_GET['id'];

    $server = "student.veleri.hr";
    $database = "oot2_izv";
    $username = "oot2";
    $password ="11";

    $conn = mysqli_connect($server, $username, $password, $database) or 
        die("Konekcija nije uspješna");
    
    $query = "SELECT ukupan_broj-rezervirani-iznajmljeni AS slobodni FROM film WHERE id=".$id;

    $res = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($res)){
        if ($row['slobodni'] <= 0) {
            echo "Nema slobodnih filmova";
            mysqli_close($conn);
            exit();
        }
    }

    $query1 = "UPDATE film SET rezervirani=rezervirani+1 WHERE id =".$id;
    $res1 = mysqli_query($conn, $query1);
    if ($res1) {
        echo "Film je uspješno ažuriran";
    } else {
        echo $query1;
    }
    $datenow = new DateTime('now');
    $query2 = "INSERT INTO rezervacija VALUES (NULL, '".date('Y-m-d H:i:s')."', 4, ".$id.")";
    $res2 = mysqli_query($conn, $query2);
    if ($res2) {
        echo "Rezervacija je dodana";
    } else {
        echo $query2;
    }
    mysqli_close($conn);

?>
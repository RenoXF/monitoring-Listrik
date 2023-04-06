<?php

define('__IN_SCRIPT__', true);

require_once './helpers/base_url.php';
require_once './includes/connection.php';
require_once './includes/header.php';

session_start();

if (!isset($_SESSION["username"])) {
  echo "Anda harus login dulu <br><a href='index.php'>Klik disini</a>";
  exit;
}

$level=$_SESSION["level"];

if ($level!="admin") {
    echo "Anda tidak punya akses pada halaman admin";
    exit;
}

$komporSql = $mysqli->query("SELECT * FROM `meter` GROUP BY `meter`.`ID_Kompor` ORDER BY `meter`.`ID` DESC");

$kompor = $komporSql->fetch_all(MYSQLI_ASSOC);
?>
<main class="container">
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-stripped align-middle">
                    <thead class="text-center">
                        <tr>
                        <th class="text-center"><strong>ID Kompor</strong></th>
                            <th>Voltage (V)</th>
                            <th>Current (A)</th>
                            <th>Power (W)</th>
                            <th>Energy (KWh)</th>
                            <th>Frequency (Hz)</th>
                            <th>PF</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kompor as $item) { ?>
                        <tr>
                            <td>
                                <a href="details.php?ID_Kompor=<?php echo $item['ID_Kompor'];?>"><?php echo $item['ID_Kompor'];?></a>
                            </td>
                            <td>
                            <?php echo $item['Voltage'];?>
                            </td>
                            <td><?php echo $item['Current'];?></td>
                            <td><?php echo $item['Power'];?></td>
                            <td><?php echo $item['Energy'];?></td>
                            <td><?php echo $item['Frequency'];?></td>
                            <td><?php echo $item['PF'];?></td>
                            <td class="text-end">
                            <?php echo $item['Date'];?>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main><?php

require_once './includes/footer.php'
?>

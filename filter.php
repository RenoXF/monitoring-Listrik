<?php

define('__IN_SCRIPT__', true);

require_once './includes/header.php'

?>
<main class="container">
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <h2 class="text-center">ID Kompor <?php echo 1 ?> </h2>
                <table class="table table-bordered table-hover table-stripped align-middle">
                    <thead class="text-center">
                        <tr>
                            <th>Voltage</th>
                            <th>Current</th>
                            <th>Power</th>
                            <th>Energy</th>
                            <th>Frequency</th>
                            <th>PF</th>
                            <th>Last Active</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                225
                            </td>
                            <td>0.12</td>
                            <td>34.5</td>
                            <td>2.5</td>
                            <td>50</td>
                            <td>0.76</td>
                            <td class="text-end">
                                2020-05-01 08:26:36
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main><?php

require_once './includes/footer.php'
?>

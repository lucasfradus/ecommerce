<?php $this->view('frontend/email/_header'); ?>
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="color:#FFFFFF;background-color:#325cbb;">
                <tr>
                    <td align="center" valign="top">
                    <table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
                        <tr>
                            <td align="center" valign="top" width="500" class="flexibleContainerCell">
                                <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" valign="top" class="textContent">
                                        <img src="<?php echo base_url('assets/public/logo_limpieza_web.png') ?>" width="200">
                                    </td>
                                </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- // MODULE ROW -->
    <tr>
        <td align="center" valign="top">
            <!-- CENTERING TABLE // -->
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td align="center" valign="top">
                    <!-- FLEXIBLE CONTAINER // -->
                        <br>
                            <h2 style="text-align:center;font-weight:normal;font-family:Helvetica,Arial,sans-serif;font-size:23px;margin-bottom:0px;margin-top: 0px;color:#008fcc;line-height:135%;">
                                Restablecer contraseña <br/> + LIMPIEZA
                            </h2>
                        <br>
                    <!-- // FLEXIBLE CONTAINER -->
                    </td>
                </tr>
            </table>
            <!-- // CENTERING TABLE -->
        </td>
    </tr>
    <!-- // MODULE ROW -->
    <!-- MODULE ROW // -->
    <tr>
        <td align="center" valign="top">
            <!-- CENTERING TABLE // -->
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td align="center" valign="top">
                        <!-- FLEXIBLE CONTAINER // -->
                        <table border="0" cellpadding="30" cellspacing="0" width="500" class="flexibleContainer">
                            <tr>
                                <td style="padding-top:0;" align="center" valign="top" width="500" class="flexibleContainerCell">
                                    <!-- CONTENT TABLE // -->
                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="flexibleContainer">
                                        <tr>
                                            <td align="left" valign="top" class="textContent">
                                                <div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:10px;color:#5F5F5F;line-height:135%;">
                                                    Estos son los datos de su cuenta:<br/>
                                                    Email: <?php echo $dato['email']; ?><br/>
                                                    Contraseña: <?php echo $dato['password']; ?><br/>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // CONTENT TABLE -->
                                </td>
                            </tr>
                        </table>
                        <!-- // FLEXIBLE CONTAINER -->
                    </td>
                </tr>
            </table>
            <!-- // CENTERING TABLE -->
        </td>
    </tr>
<?php $this->view('frontend/email/_footer'); ?>
<div marginheight="0" marginwidth="0" style="background-color:#ececec">

    <table style="width:100%!important;table-layout:fixed" align="center" bgcolor="#ececec">
        <tbody>
            <tr>
                <td>
                    <table style="max-width:600px;margin:auto" align="center">
                        <tbody>
                            <tr>
                                <td style="padding-top:20px;text-align:center" align="center" width="100%">
                                    <img alt="RED BASA" src="http://recetas.grupobasa.com.ar/img/logo_receta.png" style="font-family: Arial,Helvetica,sans-serif;font-size: 36px;font-weight: bold;color: #233c1a;">
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size:16px;font-weight:bold;padding-top:20px;padding-bottom:20px;padding-left:25px;padding-right:25px;text-align:center;color:#353e4a;font-family:Arial,sans-serif" align="center" width="100%">
                                    Este es un email enviado autom&aacute;ticamente por sistema, no debe ser respondido.
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-bottom:8px">
                                    <table style="color:#353e4a;font-family:Arial,sans-serif;font-size:12px;margin:auto" align="center" bgcolor="#ffffff" border="0">
                                        <tbody>
                                            <tr>
                                                <td style="color:#1e80b6;padding-top:20px;padding-bottom:10px;padding-left:20px;padding-right:20px;font-size:24px">
                                                    Receta Electrónica
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="line-height:24px;padding-left:20px;padding-right:20px;padding-bottom:10px;font-size: 15px;">
                                                    <div>
                                                        <div style="font-family: Arial,Helvetica,sans-serif;">
                                                            <hr />
                                                            <br />
                                                            <p>Tiene disponible para descargar las siguientes recetas:</p>
                                                            <ul>
                                                                @foreach ($parametros as $key => $v)
                                                                <li>N° de receta: {{$v->rec_id}}, vigencia: {{$v->rec_vigencia}},
                                                                    <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/verRecetaQR/". $v->rec_hash ?>">click aquí para descargar</a>
                                                                </li>
                                                                @endforeach
                                                            </ul>
                                                            <p>Tenga en cuenta que no es necesario imprimir las mismas, solo en caso que se lo requiera</p>
                                                            <p>La farmacia puede identificar la receta por el número de la misma o escaneando el código QR desde su celular</p>
                                                            <br>
                                                            <p>Gracias por contar con nuestros servicios</p>
                                                        </div>

                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="height:5px" height="5"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td style="background-color:#ececec">
                                    <table width="100%" border="0" align="center" style="color:#353e4a;font-family:Arial,sans-serif;font-size:14px;padding-left:33px;padding-right:33px;font-size:22px">
                                        <tbody>
                                            <tr>
                                                <td style="color:#717175;font-size:12px;padding-top:10px;padding-bottom:10px">
                                                    Este email se ha generado automáticamente. Por favor, no conteste este email.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="color:#717175;font-size:12px;padding-top:10px;padding-bottom:8px">
                                                    Si no desea recibir más un mail como este, por favor de aviso por mail a soporte@grupobasa.com.ar
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </td>
            </tr>
        </tbody>
    </table>

</div>
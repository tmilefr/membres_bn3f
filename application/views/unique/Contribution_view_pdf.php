<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style type="text/css">
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, Verdana, Geneva, Sans-serif;
        font-size: 14px;
        color: #4F5155;
    }

    @page {
        margin: 10px 20px 20px 40px;
    }

    #header {
        position: fixed;
        left: 0px;
        top: 0px;
        right: 0px;
        height: 90px;
    }

    #footer {
        position: fixed;
        left: 0px;
        bottom: 0px;
        right: 0px;
        height: 100px;
    }

    #footer .page:after {
        content: counter(page, upper-roman);
    }

    #footer p {
        font-size: 10px;
        text-align: left;
        padding-left: 100px;
    }

    #content {
        padding-top: 200px;
        padding-bottom: 40px;
        width: 100%;
    }

    .nowrap {
        white-space: nowrap;
    }

    .small {
        font-size: 10px;
    }

    .souligne {
        border-bottom: 0.5px solid #000000;
    }

    .sep_dashed {
        border-bottom: 1px dotted #000000;
        padding-top: 5px;
    }

    .text-right {
        text-align: right;
    }

    .text-center {
        text-align: center;
    }
    
    .divTable{
        display: table;
        width: 100%;
        background-color: #FFF;
        margin: auto;
    }
    .divTableRow {
        display: table-row;
    }
    .divTableHeading {
        background-color: #EEE;
        display: table-header-group;
    }
    .divTableCell, .divTableHead {
        display: table-cell;
        padding: 2px;
        margin: 0px;
        font-family: Arial, Verdana, Geneva, Sans-serif;
        font-size: 11px;
        vertical-align: top;
    }

    .divTableHead {
        font-weight: bold;
        font-size: 14px;
        background-color: #666;
        color: #fff;
        padding: 0px 2px 0px 2px;
        white-space: nowrap;
        vertical-align: top;
    }

    .divTableHeading {
        background-color: #EEE;
        display: table-header-group;
        font-weight: bold;
    }
    .divTableFoot {
        background-color: #EEE;
        display: table-footer-group;
        font-weight: bold;
    }
    .divTableBody {
        display: table-row-group;
    }



    h1 {
        color: #444;
        font-size: 22px;
        margin: 0;
        padding: 0;
    }

    h2 {
        color: #444;
        font-size: 16px;
        margin: 0;
        padding: 0;
    }


    h3 {
        color: #444;
        font-size: 14px;
        margin: 0;
        padding: 0;
    }

    h4 {
        color: #444;
        font-size: 12px;
        margin: 0;
        padding: 0;
    }

    p {
        font-size: 11px;
        margin: 0;
        padding: 0;
        text-align:justify;
    }

    .p50{
        width:50%;
    }

    .p60{
        width:60%;
    }

    .p70{
        width:70%;
    }

    .pair {
        background-color: #F4FAFF;
        color: #515252;
    }

    .red {
        color: #E0212F;
    }

    .blue {
        color: #72B1D7;
    }

    .violet {
        color: #AF5C91;
    }

    .underline {
        text-decoration: underline;
    }

    .nowrap {
        white-space: nowrap;
    }
    </style>
</head>

<body>
    <div id="header">
        <div class="divTable">
                <div class="divTableRow">
                <div class="divTableCell"><?php echo $logo;?></div>
                <div class="divTableCell text-right">
                    <h1>Base Nautique des 3 frontières</h1>
                    <h2>Appel à cotisation Année <?php echo $year_inprogress;?></h2>
                    <p>Section <?php echo $datas->user->section;?></p>
                </div>
            </div>
            <div class="divTableRow">
                <div class="divTableCell">&nbsp;</div>
                <div class="divTableCell">
                    <h2>
                        <?php echo $datas->user->name.' '.$datas->user->surname;?><br />
                        <?php echo $datas->user->adresse;?><br />
                        <?php echo $datas->user->cp.' '.$datas->user->ville;?>
                    </h2>
                </div>
                <div class="divTableCell">&nbsp;</div>
            </div>
        </div>
    </div>
    <div id="footer">
        <h3>Base Nautique des 3 frontières</h3>
        <p>RIB</p>
        <div class="divTable">
            <div class="divTableBody">
                <div class="divTableRow">
                    <div class="divTableCell p70">
                        <div class="divTable">
                            <div class="divTableBody">
                                <div class="divTableRow">
                                    <div class="divTableCell sep_dashed">Banque</div>
                                    <div class="divTableCell sep_dashed">Guichet</div>
                                    <div class="divTableCell sep_dashed">N° Compte</div>
                                    <div class="divTableCell sep_dashed">Clé</div>
                                    <div class="divTableCell sep_dashed">DEV</div>
                                </div>
                                <div class="divTableRow">
                                    <div class="divTableCell sep_dashed">10278</div>
                                    <div class="divTableCell sep_dashed">03050</div>
                                    <div class="divTableCell sep_dashed">00021587145</div>
                                    <div class="divTableCell sep_dashed">35</div>
                                    <div class="divTableCell sep_dashed">EUR</div>
                                </div>
                            </div>
                        </div>
                        <p>IBAN</p>
                        <div class="divTable">
                            <div class="divTableBody">
                                <div class="divTableRow">
                                    <div class="divTableCell sep_dashed">FR76</div>
                                    <div class="divTableCell sep_dashed">1027</div>
                                    <div class="divTableCell sep_dashed">8030</div>
                                    <div class="divTableCell sep_dashed">5000</div>
                                    <div class="divTableCell sep_dashed">0215</div>
                                    <div class="divTableCell sep_dashed">8714</div>
                                    <div class="divTableCell sep_dashed">535</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="divTableCell">&nbsp;</div>
                </div>
            </div>
        </div>
    </div>
    <div id="content">
        <div class="divTable">
            <div class="divTableHeading">
                <div class="divTableRow ">
                    <div class="divTableCell sep_dashed">Designation</div>
                    <div class="divTableCell sep_dashed">Montant</div>
                    <div class="divTableCell sep_dashed">Nb</div>
                    <div class="divTableCell sep_dashed">Taux</div>
                    <div class="divTableCell sep_dashed">Total</div>
                </div>
            </div>
            <div class="divTableBody">
                <?php 
				foreach($datas->services AS $key=>$service) { 
				?>
                <div class="divTableRow <?php echo ((is_float($key/2)) ? 'pair':'');?>">
                    <div class="divTableCell sep_dashed"><?php echo $service->name;?></div>
                    <div class="divTableCell sep_dashed"><?php echo $service->amount;?></div>
                    <div class="divTableCell sep_dashed">1</div>
                    <div class="divTableCell sep_dashed"><?php echo $service->taux;?></div>
                    <div class="divTableCell sep_dashed"><?php echo $service->total;?></div>
                </div>
                <?php } ?>
            </div>
            <div class="divTableFoot">
                <div class="divTableRow">
                    <div class="divTableCell">
                        <p>Montant à payer ( provisions jounrées de travail NON incluses)</p>
                    </div>
                    <div class="divTableCell">&nbsp;</div>
                    <div class="divTableCell">&nbsp;</div>
                    <div class="divTableCell">&nbsp;</div>
                    <div class="divTableCell"><?php echo $datas->real;?> €</div>
                </div>
            </div>
        </div>

        <div >
            <p>Si vous désirez changer de type de cotisation (familliale, individuelle, jeune) merci d'en avertir le comité</p>
            <br />
            <p>Payement par chèque, liquide ou virement bancaire. (RIB ci-joint)</p>
            <br />
        </div>

        <?php if ($datas->taux->code != 'C' && $datas->taux->code != 'D'){ ?>
            <div class="divTable">
                <div class="divTableHeading">
                    <div class="divTableRow ">
                        <div class="divTableCell p60">Provisions journées de travail encaissées en <?php echo $year_prec;?></div>
                        <div class="divTableCell"> 
                            <?php 
                            if (isset($datas->check->encaisse) AND $datas->check->encaisse ){
                                echo (($datas->check->encaisse == "...") ? 'Aucun':$datas->check->encaisse.' €');
                            }?>
                        </div>
                    </div>    
                    <div class="divTableRow ">
                        <div class="divTableCell p60">Provisions journées de travail à régler pour <?php echo $year_inprogress;?> </div>
                        <div class="divTableCell">
                            <?php 
                            if (isset($datas->check->todo) AND $datas->check->todo){ 
                                 echo (($datas->check->todo == '...') ? 'Aucun':$datas->check->todo.' €');
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (isset($datas->check->have) AND $datas->check->have){ ?>
            <p>Chèque en notre possession : <?php echo $datas->check->have;?></p><br/><br/>
            <?php } ?>
            <p>
                <b><u>Provisions journées de travail</u></b> : <br/>Merci de joindre des chèques séparés pour les
                journées de travail (Que nous n'encaisserons pas). En cas de payement en liquide ou par virement, (ceux qui ne disposent pas d'un chéquier) merci
                d'ajouter le montant des provisions à votre montant total.<br/>
                P.S. Mettez impérativement l'ordre (BN3F) sur vos chèques de provisions. Si vous ne mettez pas
                de date, cela vous évitera d'en refaire l'année prochaine ...
            </p>

        <?php } else { ?>
                    <h3>Provisions journées de travail : Exonéré</h3>
        <?php } ?>
        <br /><br />
        <div class="divTable">
            <div class="divTableHeading">
                <div class="divTableRow ">
                    <div class="divTableCell sep_dashed">Date limite de payement </div>
                    <div class="divTableCell sep_dashed  text-right">28 février <?php echo $year_inprogress;?> </div>
                </div>    
                <div class="divTableRow ">
                    <div class="divTableCell">Majoration pour payement ultérieur</div>
                    <div class="divTableCell text-right">50 € par mois entamé</div>
                </div>
            </div>
        </div>
        <br /><br />
        <p><b>Au 1er avril, l’accès sera bloqué pour les membres non à jour de cotisation</b><br />
        <span class="red">après cette date, vous devrez re-payer les droits d'entrée comme un nouveau membre</span></p>
        <br /><br />
        <h3>Pour le comité</h3>

    </div>

</body>

</html>
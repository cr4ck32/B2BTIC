<?xml version="1.0" encoding="UTF-8"?> 
<xsl:stylesheet version="1.0" 
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"> 
<xsl:template match="/"> 
 <html> 
  <head>
        <title>Archivos</title>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"/>
    <link rel="stylesheet" href="../template/css/main.css" />
   
   <!-- Favicon -->
    <link href="img/favicon.ico" rel="shortcut icon" />

    <!-- Stylesheets -->
    <link rel="stylesheet" href="../template/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../template/css/font-awesome.min.css" />
    <!-- Main Stylesheets -->
    <link rel="stylesheet" href="../template/css/style.css" />
    <link rel="stylesheet" href="../template/css/main.css" />

    </head>
 <body> 


 <div id="preloder">
        <div class="loader"></div>
    </div>

    <header class="header-section clearfix">
        <a href="/" class="site-logo"><img src="../template/img/logo.png" alt=""/></a>
    </header>


    <section class="concept-section spad">
      <div class="container">
          <div class="row">
              <div class="col-lg-12">
                  <div class="section-title">
                    <h2>Lista de Archivos</h2>
                  </div>


 <div class="col-lg-12 table-responsive">
    <table border="1" align="center" style="width: 100%;"  class="table col-sm-12 table-bordered table-striped table-condensed cf"> 
   <tr> 
    <th>Id</th> 
    <th>Nombre</th> 
    <th>Extension</th> 
    <th>Tipo</th> 
	<th>fec_Registro</th> 
   </tr> 
    <xsl:for-each select="Archivos/Archivo"> 
   <tr> 
    <td><xsl:value-of select="@Id"/></td> 
    <td><xsl:value-of select="@Nombre"/></td> 
    <td><xsl:value-of select="@Extension"/></td> 
    <td><xsl:value-of select="@Tipo"/></td> 
	<td><xsl:value-of select="@fec_Registro"/></td> 
   </tr> 
    </xsl:for-each> 
    </table> 
 </div>
	   </div>
          </div>
      </div>
    </section>





          <!--====== Javascripts & Jquery ======-->
          
          <script src="../template/js/jquery-3.2.1.min.js"></script>
    <script src="../template/js/bootstrap.min.js"></script>
          <script src="../template/js/main.js"></script>
	
</body> 
</html> 
</xsl:template> 
</xsl:stylesheet> 
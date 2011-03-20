
  <table  width="90%" align="center" >
    <tr>
      <td class="c" colspan="2">
        <div align="center">Noticias</div>
      </td>
    </tr>
    <tr valign="middle">
      <td class="anything"  width="80%">
          <div align="center">
              <label>Titulo:</label><b>{news_titulo}</b><br>
              <div align="center">{news_news}</div>
          </div>
      </td>
    </tr>
    
  </table>

<table width="90%" align="center">
  <tr valign="top">
    <td class="c" width="5%">
      <div align="center"><b>ID</b></div>
    </td>
    <td class="c" width="60%">
      <div align="center"><b>Titulo de la noticia</b></div>
    </td>
    <td class="c" width="26%">
      <div align="center"><b>Fecha</b></div>
    </td>
    <td class="c" width="9%">
      <div align="center"><b>Acción</b></div>
    </td>
  </tr>
  <!-- START BLOCK : list_noticias -->
    <tr valign="middle">
        <th width="5%">
            <div align="center">{id_news}</div>
        </th>
        <th width="60%">{news_titulo}</th>
        <th width="26%">
            <div align="center">{news_date}</div>
        </th>
        <th width="9%">
            <div align="center">
                <a href="?page=news&idnews={id_news}">
                    <img border="0" src="styles/images/editnew.gif" width="15" height="15" alt="Ver noticia" title="Ver noticia">
                </a>
            </div>
        </th>
    </tr>
      <!-- END BLOCK : list_noticias -->
</table>
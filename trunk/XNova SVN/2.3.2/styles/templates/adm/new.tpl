<form name="newsform" method="post" action="?page=news">
  <table width="90%" align="center" >
    <tr>
      <td colspan="2">
        <div align="center">Administración de Noticias</div>
      </td>
    </tr>
    <tr valign="middle">
      <td width="80%">
          <div align="center">
              <label>Titulo de la noticia: </label><input type="text" name="titulo">
        	<textarea name="news" rows="15" cols="80" id="noticias">{news_news_edit}</textarea>
          </div>
      </td>
    </tr>
    <tr valign="middle">
      <td colspan="2">
        <div align="center">
                <input type="hidden" name="id_news" value="{id_news_edit}">
                <input type="submit" name="tipo" value="Modificar">
		<input type="submit" name="tipo" value="Anadir">
		<input type="reset" name="Reset" value="Resetear">
          </div>
      </td>
    </tr>
  </table>
</form>
<table width="90%" border="1" cellspacing="0" cellpadding="0" align="center">
  <tr valign="top">
    <td width="5%">
      <div align="center"><b>ID</b></div>
    </td>
    <td  width="60%">
      <div align="center"><b>Titulo de la noticia</b></div>
    </td>
    <td width="26%">
      <div align="center"><b>Fecha</b></div>
    </td>
    <td width="9%">
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
                <a href="?page=news&idnews={id_news}&actionnews=editar">
                    <img border="0" src="styles/images/editnew.gif" width="15" height="15" alt="Modificar Noticia" title="Modificar Noticia">
                </a>
	  
                <a href="?page=news&idnews={id_news}&actionnews=borrar">
                    <img border="0" src="styles/images/deletenew.gif" width="15" height="15" alt="Borrar Noticia" title="Borrar Noticia">
                </a>
            </div>
        </th>
    </tr>
      <!-- END BLOCK : list_noticias -->
</table>
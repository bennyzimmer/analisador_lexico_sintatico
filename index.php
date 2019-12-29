<!DOCTYPE html>

<html>
  <head>
    <title>Atividade - Analisador Léxico</title>
    <meta charset="utf-8">
  </head>
  <body>
    <div style="width: 49%; float: left">
      <?php 
        echo isset($_POST['analisar']) ? '<h1>Análise Léxica</h1>' : '';
        include 'lexico.php';
      ?>
    </div>
      
    <div style="width: 49%; float: left">
      <?php 
        echo isset($_POST['analisar']) ? '<h1>Análise Sintática</h1>' : '';
        include 'sintatico.php';
      ?>
    </div>
    <div style="width: 100%; float: left">
      <h1>Entrada da Linguagem</h1>
      <p>Abaixo um exemplo do código testado para a análise:</p>
     
      <pre style="border: solid 1px; width: 150px; padding: 15px; float:left">if(num > 10) {}</pre>
      <b style="float:left; margin: 20px 15px;">OU</b>
      <pre style="border: solid 1px; width: 150px; padding: 15px; float:left">while(num > 10) {}</pre>
      <b style="float:left; margin: 20px 15px;">OU</b>
      <pre style="border: solid 1px; width: 150px; padding: 15px; float:left">while(true) {}</pre>
      
    </div>
    <form method="POST">
      <textarea style="float: left" type="text" cols="80" rows="6" name="texto" placeholder="Digite um comando para ser analisado..." ><?=isset($_POST['texto']) ? $_POST['texto'] : '' ?></textarea>
      <input style="height: 96px; float: left" type="submit" name="analisar" value="Analisar">
    </form>
  </body>
</html>
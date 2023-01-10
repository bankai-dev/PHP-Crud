function moveUp(ID) {
  // Envia uma solicitação AJAX para mover a tarefa para cima
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "/lista--tarefas/index.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
        var resp = JSON.parse(xhr.responseText);
        if (resp.error){
            alert(resp.error);
        }else{
            console.log("Posição da tarefa atualizada com sucesso");
        }
    }
  };
  xhr.send("ID=" + ID + "&direction=up");
}

function moveDown(ID) {
  // Envia uma solicitação AJAX para mover a tarefa para cima
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "/lista--tarefas/index.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
        var resp = JSON.parse(xhr.responseText);
        if (resp.error){
            alert(resp.error);
        }else{
            console.log("Posição da tarefa atualizada com sucesso");
        }
    }
  };
  xhr.send("ID=" + ID + "&direction=down");
}

  
  
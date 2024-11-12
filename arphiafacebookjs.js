var configMenu = document.querySelector(".settings-menu");
var escuro = document.getElementById("dark-btn");

function abreConfig(){
    configMenu.classList.toggle("settings-menu-height");
}

escuro.onclick = function(){
    escuro.classList.toggle("dark-btn-on");
    document.body.classList.toggle(".dark-theme");

    if(localStorage.getItem("theme") == "light"){
        localStorage.setItem("theme", "dark");
    }else{
        localStorage.setItem("theme", "dark");
    }
}
document.getElementById('dark-btn').addEventListener('click', function() {
    document.body.classList.toggle('night-mode');
});

                                                                   document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('publicarBtn').addEventListener('click', function() {
      adicionarPostagem();
    });
  });
  
  function adicionarPostagem() {
    var texto = document.getElementById('texto').value;
  
    if (texto.trim() !== '') {
      var postagensDiv = document.getElementById('postagens');
      var novaDiv = document.createElement('div');
      novaDiv.className = 'postagem';
      novaDiv.textContent = texto;
  
      // Inserir a nova postagem no topo
      postagensDiv.insertBefore(novaDiv, postagensDiv.firstChild);
  
      // Limpar o campo de texto após a publicação
      document.getElementById('texto').value = '';
    }
  }

  //rodrigo
  document.getElementById("publishBtn").addEventListener("click", function() {
    let commentBox = document.getElementById("commentBox");
    let commentText = commentBox.value.trim();

    if (commentText === "") {
        alert("Por favor, escreva um comentário.");
        return;
    }

    let commentSection = document.getElementById("commentSection");
    
    // Criar div para o novo comentário
    let newComment = document.createElement("div");
    newComment.className = "comment";
    newComment.innerHTML = `<p>${commentText}</p> <button class="deleteBtn">Apagar</button>`;
    
    commentSection.appendChild(newComment);
    
    // Limpar a caixa de texto
    commentBox.value = "";

    // Adicionar funcionalidade ao botão de apagar
    let deleteBtn = newComment.querySelector(".deleteBtn");
    deleteBtn.addEventListener("click", function() {
        newComment.remove();
    });
});

document.getElementById("clearBtn").addEventListener("click", function() {
    document.getElementById("commentBox").value = "";
});

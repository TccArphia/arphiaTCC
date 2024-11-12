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

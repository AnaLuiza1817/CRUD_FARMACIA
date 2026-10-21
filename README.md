# 💊 Sistema de Controle de Reposição de Medicamentos

![Status](https://img.shields.io/badge/Status-Conclu%C3%ADdo-brightgreen)
![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?logo=css3&logoColor=white)

Um sistema web moderno e intuitivo para o gerenciamento de reposição de estoque em farmácias. Desenvolvido para otimizar o fluxo de pedidos, desde a solicitação até a entrega final ao setor responsável.

---

## 🚀 Funcionalidades

- **Painel Kanban:** Visualização clara dos pedidos divididos em *Solicitado*, *Em Separação* e *Recebido*.
- **Gestão de Urgência:** Identificação visual (badges coloridas) para pedidos de alta, média e baixa urgência.
- **Cadastro Rápido:** Formulários dedicados para cadastrar novos funcionários e novos pedidos de medicamentos.
- **Edição e Exclusão:** Atualização facilitada do status, edição de dados do pedido e exclusão com confirmação.
- **Design Responsivo e Limpo:** Interface focada na experiência do usuário, com paleta de cores voltada para a área da saúde.

---

## 🛠️ Tecnologias Utilizadas

- **Backend:** PHP (Puro, sem frameworks)
- **Banco de Dados:** MySQL
- **Frontend:** HTML5, CSS3 (Flexbox)
- **Comunicação:** PDO (PHP Data Objects) para segurança contra SQL Injection.

---

## 📁 Estrutura do Projeto

```text
📦 crud_farmacia 
 ┣ 📂 Banco de Dados
 ┃ ┗ 📜 db.sql
 ┣ 📂 CSS
 ┃ ┗ 🎨 style.css
 ┣ 📂 Infra
 ┃ ┗ 🐘 conexao.php
 ┣ 📂 Pages
 ┃ ┣ 🐘 cadastro_funcionario.php
 ┃ ┗ 🐘 cadastro_pedido.php
 ┣ 📂 Actions
 ┃ ┣ 🐘 atualizar.php
 ┃ ┣ 🐘 editar.php
 ┃ ┗ 🐘 excluir.php
 ┣ 🐘 index.php
 ┗ 📜 README.md

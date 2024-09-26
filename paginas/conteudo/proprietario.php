<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .containerP {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            flex:1;
        }
        h1 {
            color: #F08080;
            text-align: center;
        }
        form {
            background-color: #F08080;
            padding: 20px;
            border-radius: 5px;
            color: white;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        input[type="submit"] {
            background-color: white;
            color: #F08080;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #F08080;
            color: white;
        }
    </style>
    <div class="containerP">
        <h1>Cadastro do proprietario</h1>
        <form action="process.php" method="post">
        <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required><br>
            
            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco"><br>
            
            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone"><br>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email"><br>
            
            <input type="submit" value="Cadastrar">
        </form>
    </div>



<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .containerE {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
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
        button, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        button[type="submit"] {
            background-color: white;
            color: #F08080;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        button[type="submit"]:hover {
            background-color: #F08080;
            color: white;
        }
    </style>
    <div class="containerE">
    <h1>Editar agendamento</h1>
    <form method="POST" action="">
        <label for="address">Endereço:</label>
        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($agendamento['endereco_agendoacao']); ?>" required>

        <label for="date">Data da Doação:</label>
        <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($agendamento['data_agendoacao']); ?>" required>

        <label for="description">O que é a doação:</label>
        <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($agendamento['desc_agendoacao']); ?></textarea>

        <button type="submit" name="botao">Atualizar Doação</button>
    </form>
</div>
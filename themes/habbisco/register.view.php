<h1>Register</h1>

<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
    <input type="text"
           name="username"
           placeholder="username"
           required>
    <input type="password"
           name="password"
           placeholder="password">
    <input type="email"
           name="email"
           placeholder="email">
    <input type="date"
           name='nasc'
           placeholder="Data de Nascimento">

    <fieldset>
        <legend>Sexo</legend>
        <label>
            <input type="radio"
                   name="sexo"
                   value="m">
            <span>Masculino</span>
        </label>
        <br>
        <label>
            <input type="radio"
                   name="sexo"
                   value="f">
            <span>Feminino</span>
        </label>
    </fieldset>


    <button type="submit">Cadastrar</button>
</form>
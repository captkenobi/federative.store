<div id="page__signin">
    <div class="container middle__signin">
        
        <form action="/auth/login" method="POST" class="form-horizontal">           
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Login</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="login" id="inputEmail3" placeholder="Login">
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" name="password" id="inputPassword3" placeholder="Password">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Sign in</button>
              </div>
            </div>

            <?php if (isset($_SESSION["errors"]) && !empty($_SESSION["errors"])): ?>
                <?php foreach ($_SESSION["errors"] as $error): ?>
                    <p class="bg-danger" style="padding: 15px"><?= $error ?></p>
                <?php endforeach; ?>
            <?php endif; unset($_SESSION["errors"]) ?>
        </form>
        
        
    </div>
</div>
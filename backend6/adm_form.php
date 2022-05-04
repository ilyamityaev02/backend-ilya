<style>
    #form{
        border: 1px solid black;
        padding: 10px;
    }
</style>
<form id="form" method="POST" action="admin.php">
            <label>ID: <input type="text" placeholder="ID" name="uid" value="<?php print $values['id']; ?>"/><br /></label>
          <label>Имя: <input type="text" placeholder="Имя" name="fio" value="<?php print $values['fio']; ?>"/><br /></label>
          <label>Почта: <input type="email" placeholder="Email" name="email" value="<?php print $values['email']; ?>"/><br /></label>
          <label>Дата рождения: <input type="date" name="date" value="<?php print $values['date'];?>"/><br /></label>
          <label>
          <label>
            Пол:
            <input type="radio" name="gender" value="male" <?php if($values['gender'] == 'male'){print 'checked';};?>/>Мужской
          </label>
          <label>
            <input type="radio" name="gender" value="female" <?php if($values['gender'] == 'female'){print 'checked';};?>/>Женский
          </label>
          </label>
          <br />
          <label>
          <label>
            Кол-во конечностей:
            <input type="radio" name="arms" value="1" <?php if($values['arms'] == '1'){print 'checked';};?>/>1
          </label>
          <label> <input type="radio" name="arms" value="2" <?php if($values['arms'] == '2'){print 'checked';};?>/>2 </label>
          <label>
            <input type="radio" name="arms" value="more" <?php if($values['arms'] == '3'){print 'checked';};?>/>3 и более
          </label>
          </label>
          <br />
          <label>
            Сверхспособность:<br />
            <select name="arg[]" multiple="multiple">
              <option value="god" <?php $a = explode(',',$values['arg']); foreach ($a as $key){if($key == 'god'){print 'selected';}}?>>Бессмертие</option>
              <option value="wall"<?php $a = explode(',',$values['arg']); foreach ($a as $key){if($key == 'wall'){print 'selected';}}?>>Прохождение сквозь стены</option>
              <option value="fly"<?php $a = explode(',',$values['arg']); foreach ($a as $key){if($key == 'fly'){print 'selected';}}?>>Левитация</option>
            </select> </label
          ><br />
          <label> Биография:<br/> <textarea name="about"><?php print $values['about']; ?></textarea></label><br /><br>
          <input type="submit" value="Изменить"  name="update">
          <input type="submit" value="Удалить пользователя"  name="delete">
</form>

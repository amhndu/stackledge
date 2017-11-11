<div class="newpost">
  <form action="submitpost.php">

    <label for="title">Title</label>
    <input type="text" id="title" name="Title" placeholder="Title..">

    <label for="url">URL</label>
    <input type="text" id="url" name="lastname" placeholder="http://..">

    <label for="category">Category</label>
    <select name="category">
          <?php
            foreach ($categories as $cat)
                echo "<option value='$cat'>$cat</option>";
		  ?>
		</select>

    <input type="submit" value="Submit">
  </form>
</div>

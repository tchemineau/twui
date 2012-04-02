
  <form class="form-horizontal">
    <fieldset>
      <legend>Create a new test configuration file</legend>
      <div class="control-group">
        <label class="control-label" for="test_name">Name</label>
        <div class="controls">
          <input type="text" class="span3" name="test_name" id="test_name"></input>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="test_template">Template</label>
        <div class="controls">
          <select class="span3" name="test_template" id="test_template">
            <option value="none">Vide</option>
            <option value="template1">Template n°1</option>
          </select>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="test_content">Configuration file</label>
        <div class="controls">
          <textarea class="span11" name="test_content" id="test_content" rows="10"></textarea>
          <p class="help-block">The Tsung test configuration file is in XML format. See <a href="http://tsung.erlang-projects.org/user_manual.html" target="_blank">the online documentation</a>.</p>
        </div>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn btn-primary">Create test</button>
      </div>
    </fieldset>
  </form>

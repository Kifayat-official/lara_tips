<div class="form-group">
    <label>User Name</label>
    <input type="text" class="form-control" name="header[username]" value="{{$mdc_test_session->writeCommunicationProfile->username}}" required autocomplete="new-password" />
</div>

<div class="form-group">
    <label>Password</label>
    <input type="password" class="form-control" name="header[password]" value="{{$mdc_test_session->writeCommunicationProfile->password}}" required autocomplete="new-password" />
</div>

<div class="form-group">
    <label>Code</label>
    <input type="code" class="form-control" name="header[code]" value="{{$mdc_test_session->writeCommunicationProfile->code}}" required autocomplete="new-password" />
</div>
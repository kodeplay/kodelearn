<div class="r pagecontent">
    <div class="pageTop">
        <div class="pageTitle l">Settings</div>
        <div class="pageDesc r">You can select which languages are enabled in KodeLearn.</div>
        <div class="clear"></div>
    </div><!-- pageTop -->
    
    <div class="topbar">
        <a href="#" class="pageTab active">General</a>
        <a href="#" class="pageTab">Languages</a>
        <a href="#" class="pageTab">Locations and rooms</a>
    </div><!-- topbar -->
    
    <form action="">
        <table class="formcontainer">
            <tr>
                <td><label for="insti">Institution Name</label></td>
                <td><input type="text" id="insti" /></td>
            </tr>
            <tr>
                <td><label for="instiType">Institution Type</label></td>
                <td>
                    <select id="instiType">
                        <option value="">High School</option>
                        <option value="">Junior College</option>
                        <option value="">Professional College</option>
                        <option value="">Coaching Class</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="topAlign">
                    Logo
                    <p class="tip">Preferred size: 100px</p>
                </td>
                <td><img src="http://placehold.it/100" alt="" /></td>
            </tr>
            <tr>
                <td><label for="instiURL">Institution URL</label></td>
                <td><input type="text" id="instiURL" /></td>
            </tr>
            <tr>
                <td class="topAlign"><label for="instiAddr">Address</label></td>
                <td>
                    <textarea name="" id="instiAddr" cols="30" rows="5"></textarea>
                </td>
            </tr>
            <tr>
                <td><label for="lang">Language</label></td>
                <td>
                    <select id="lang">
                        <option value="">English</option>
                        <option value="">French</option>
                        <option value="">Deutsch</option>
                        <option value="">Español</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="membership">Membership</label></td>
                <td>
                    <input type="checkbox" id="membership" /> <label for="membership">Anyone can register</label>
                </td>
            </tr>
            <tr>
                <td><label for="roleStudent">New user's default role</label></td>
                <td class="topAlign">
                    <p><input type="radio" name="defaultRole" selected id="roleStudent" /><label for="roleStudent">Student</label></p>
                    <p><input type="radio" name="defaultRole" id="roleTeacher" /><label for="roleTeacher">Teacher</label></p>
                </td>
            </tr>
            <tr>
                <td class="topAlign"><label for="uarYes">User approval required</label></td>
                <td>
                    <p><input type="radio" name="uaReq" selected id="uarYes" /><label for="uarYes">Yes</label></p>
                    <p><input type="radio" name="uaReq" id="uarNo" /><label for="uarNo">No</label></p>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input class="button" type="submit" value="Save changes" /></td>
            </tr>
        </table>
    </form>
    
</div><!-- pagecontent -->

<div class="clear"></div>
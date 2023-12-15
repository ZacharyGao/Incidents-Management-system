<?php include_once("inc/config.php"); ?>
<?php include_once("inc/header.php"); ?>

<h2>Coursework 2 - Incidents Management system</h2>

<p>
    The IMS is a web-based system that allows police officers to manage incidents, vehicles, and people. The system is to be used by police officers to record incidents, and to add and search for people and vehicles. The system is also to be used by police administrators to add new police officers and to associate fines to incidents. The system also provides an audit trail of database accesses and changes.
</p>
<br>

<h2>Core features</h2>

<h4>1. Police Login/Change password <a href="login.php">Login</a>  <span><a href="change_pw.php"> ChangePassword</a></sapn></h4>


<p>A police officer should be able to log into the system using one of the following usernames/password combinations:</p>

<table class="table table-striped">
    <tr>
        <th>username</th>
        <th>password</th>
    </tr>
    <tr>
        <td>mcnulty</td>
        <td>plod123</td>
    </tr>
    <tr>
        <td>moreland</td>
        <td>fuzz42</td>
    </tr>
</table>

<p>Once logged in, the police officer should have the ability to change their password.</p>
<p>IMPORTANT NOTE - in any real world system involving a database and web frontend, security would be paramount. However, addressing security is beyond the scope of this module, so you should ignore this. For example, usernames and passwords can be stored as plain text fields in your database - <em>do not attempt to encrypt them or secure your database in any way</em>.
</p>
<br>

<h4>2. Search people by name/driving licence and Add new person <a href="search_people.php"> People</a> </h4>
<p>The police officer should be able to <em>look up people</em> by their <strong>names</strong> or their <strong>driving licence number</strong> (by typing <em>either</em> of these into the system). If the person is <strong>not in</strong> the system, it should give an <strong>appropriate message</strong>. This search should <strong>not be case sensitive</strong> and it should <strong>work on partial names</strong>, e.g., “John”, “Smith”, and “John Smith” would all find John Smith. If there are several people with the same name, they should all be listed.</p>
<br>

<h4>3. Search vehicle by registration number <a href="search_vehicle.php">Search Vehicle</a> 
</h4>
<p>The police officer should be able to <em>look up vehicle registration (plate) number</em>. The system will then show <strong>details of the car</strong> (e.g., type, colour, etc.), the <strong>owner's name</strong>, and <strong>license number</strong>. <strong>Allow for missing data</strong> in the system, e.g., the vehicle might not be in the system, or the vehicle might be in the system but the owner might be unknown.</p>
<br>

<h4>4. Add new vehicles and corresponding owner  
    <a href="add_vehicle.php">Add vehicle</a>
</h4>
<p>The police officer should be able to <em>enter details for a new vehicle</em>. This will include the <strong>registration (plate) number</strong>, <strong>make</strong>, <strong>model</strong>, and <strong>colour</strong> of the vehicle, as well as its <strong>owner</strong>. If the owner is <strong>already in</strong> the database, then it should be a matter of <strong>selecting that person</strong> and <strong>assigning them to the new vehicle</strong>. If the owner is <strong>not in</strong> the database, they <strong>should be added</strong> (along with <strong>personal information</strong> including the <strong>license number</strong>).</p>
<br>

<h4>5. Add / Search incident info and corresponding vehicles and people
    <a href="report.php">Report</a>
</h4>
<p>The police officer should be able to <strong>file a report for an incident</strong> and <strong>retrieve existing reports</strong> (e.g., via a search). Filing new ones will involve <strong>submitting a textual statement</strong>, <strong>recording the time</strong> of the <strong>incident</strong>, and the <strong>vehicle</strong> and <strong>person</strong> involved. If <strong>either the person or the vehicle are new</strong> to the system, then appropriate new entry/entries to the database should be <strong>added</strong>. The officer should be able to <strong>record the offence from a list of offences</strong> contained in the database. <em>NOTE</em>: a fine is not stored at this stage because the fine will be issued by a court at a later time and added by an administrator. The officer should be able to retrieve and edit the report.</p>
<br>

<h4>6. Police Administrator is permitted to add Police and associate Fines to Incident
    <a href="add_police.php">Add Police</a>
    <a href="fine.php">Fine</a>
</h4>
<p>An <strong>administrator</strong> should be able to log into the system with the username “<code>daniels</code>” and the password “<code>copper99</code>”.</p>
<ul>
    <li>The administrator should be able to do everything that an ordinary police officer can do with the following additions:</li>
    <li>The administrator should be able to <strong>create new police officer accounts</strong></li>
    <li>The administrator should be able to <strong>associate fines to reports</strong></li>
</ul>
<br>

<h4>7 Administrator can review Audit log
    <a href="audit_log.php">Audit</a>
</h4>
<p>To support various regulatory and statutory requirements, police need to <strong>have access to an audit trail</strong> to account for <strong>database record accesses and changes that are made (e.g., deletions, updates, etc.)</strong>. Implement a basic auditing feature in the web interface which will enable <strong>an administrator to review</strong> the above, on a <strong>per user basis</strong> (you may extend this to provide other auditing views e.g., <strong>per record</strong>).</p>


<?php include_once("inc/footer.php"); ?>
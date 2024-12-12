<!DOCTYPE html>
<html>
<div class="content">
        <h2>Profile Page</h2>
        <div>
            <p>Your account details are below:</p>
            <table>
                <tr>
                    <td>Username:</td>
                    <td><?=htmlspecialchars($_SESSION['name'], ENT_QUOTES)?></td>
                </tr>
                <tr>
                    <td>Score:</td>
                    <td><?=htmlspecialchars($_SESSION['score'], ENT_QUOTES)?></td>
                </tr>
            </table>
        </div>
    </div>
</html>
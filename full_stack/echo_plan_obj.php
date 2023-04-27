<?php

    class PrintPlanObjects {
        function task($row, $status, $avatar, $desc, $show_more_class, $complete_button) {
            echo "
                <div class='task {$row['type']}'>
                    <form method='POST'>
                        <div class='task-top'>
                            <p class='task_name {$status}'>{$row['name']}</p>
                            <div class='flex-right'>$avatar</div>
                        </div>
                        
                        <div class='task-middle'>
                            <p class='task-description task-description-short' id='short_text_{$row['task_id']}'>$desc</p>
                            <p class='task-description show-more-text' id='show_more_{$row['task_id']}'>{$row['description']}</p>
                            <a class='show-more-button-task $show_more_class' onclick='show_more({$row['task_id']}, this)'>↑</a>
                        </div>
                        <div class='task-button-manipulation'>
                            <button type='submit' name='$complete_button' value='{$row['task_id']}'>√</button>
                            <button type='submit' name='delete' value='{$row['task_id']}'>X</button>
                        </div>
                    </form>
                </div>
            ";
        }
    }

?>
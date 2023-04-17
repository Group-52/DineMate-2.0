

# Wait for the shell prompt to appear
spawn bash
expect "$ "

# Send the command to the shell
send "php socket-server.php\r"

# Wait for the command to complete
expect "$ "

# Exit
exit

$secrets = @{
    "APP_KEY" = "base64:Mg6RM3Ed1I8oqsDS09j+AsIxwVdHs18M0B4JVr1JCVE="
    "DB_PASSWORD" = "q\+]zHNU8:;c41gp"
    "DB_DATABASE" = "trymywatch"
    "DB_USERNAME" = "root"
    "DB_HOST" = "trymywatch:asia-south1:try-my-watch"
    "DB_PORT" = "3306"
}

foreach ($name in $secrets.Keys) {
    $value = $secrets[$name]
    $tempFile = "temp_secret_$name.txt"
    $value | Out-File -FilePath $tempFile -NoNewline -Encoding utf8
    gcloud secrets versions add $name --data-file=$tempFile
    Remove-Item $tempFile
}

docker run -d -p 8001:8001 --name app-pph-be-test --user $(id -u root):$(id -g root) -v $(pwd)/code:/app -e "TZ=Europe/Athens" kvailas/pph-be-test:latest

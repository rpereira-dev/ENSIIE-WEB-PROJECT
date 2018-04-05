# update apt-get
sudo apt-get update
# install curl
sudo apt-get install curl
# install docker-compose
sudo curl -L https://github.com/docker/compose/releases/download/1.20.1/docker-compose-`uname -s`-`uname -m` -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
docker-compose version
# install docker
sudo apt-get install apt-transport-https ca-certificates -y
sudo apt-key adv --keyserver hkp://p80.pool.sks-keyservers.net:80 --recv-keys 58118E89F3A912897C070ADBF76221572C52609D
sudo echo deb https://apt.dockerproject.org/repo ubuntu-xenial main >> /etc/apt/sources.list.d/docker.list
sudo apt-get update
sudo apt-get purge lxc-docker
sudo apt-get install linux-image-extra-$(uname -r) -y
sudo apt-get install docker-engine cgroup-lite apparmor -y
sudo usermod -a -G docker $USER
sudo service docker start

* Remove dangling images
    - docker images -f dangling=true
    - docker rmi $(docker images -f dangling=true -q)

* Remove all containers
    - docker stop $(docker ps -a -q)
    - docker rm $(docker ps -a -q)

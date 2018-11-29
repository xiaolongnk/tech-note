#/bin/bash
 
# date: 2018-10-14
# auth: phenix <xiaolongnk@126.com>
# generate nginx config for laravel projects.

NGINX_CONF_PATH="/usr/local/etc/nginx/servers/"
NGINX_TEMPLATE_FILE="./nginx_template.conf"

if [ $# -lt 1 ]
then
    echo "usage:./generateNginxConf.sh path"
    echo "path is necessary, you must specified it."
    exit 1
fi

targetPath=$1
if [ ! -d "$targetPath" ]
then
    echo "invalid path $targetPath, please check"
    exit 2
fi

#pwd=`pwd`
#projects=`ls "$targetPath" | sed "s:^:$targetPath/: "`
for ipath in $*
do
    projects=`ls "$ipath"`
    for i in $projects
    do
        confInstance="$i"
        codePath="$targetPath/$i"
        outputNginxConfName="$NGINX_CONF_PATH/$i.conf"
        storagePath="$codePath/storage"
        bootstrapPath="$codePath/bootstrap"
        cat $NGINX_TEMPLATE_FILE \
            | sed "s|CONF_INSTANCE|$confInstance|g" \
            | sed "s|CODE_REAL_PATH|$codePath|g" > $outputNginxConfName
        ret=`grep -c "$i" /etc/hosts`
        if [ $ret -eq '0' ]
        then
            echo "127.0.0.1 $i" >> /etc/hosts
        fi
        if [ -d "$storagePath" ]
        then
            chmod -R 777 "$storagePath"
        fi
        if [ -d "$bootstrapPath" ]
        then
            chmod -R 777 "$bootstrapPath"
        fi
    done
    echo "process finished [$ipath]"
done

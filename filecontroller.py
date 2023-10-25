# -*- coding: utf-8 -*-
import requests
import os
from datetime import datetime
import time
# ★ポイント1
# ex) set DOWNLOAD_SAVE_DIR=C:/Temp/flaskDownloadSaveDir
DOWNLOAD_SAVE_DIR = os.getenv("C:\\Users\\kazuk\\Documents\\programing\\python\\result")

# main
if __name__ == "__main__":
    i=0
    # ★ポイント2
   

    # ★ポイント3
    while(1):  
        try:
            while(1):
            
                url = 'http://192.168.0.20/image.php'
                if i==0:
                    response = requests.get(url)
                else:
                    url=url+"?number="+str(i)
                    response=requests.get(url)
                path = r"C:\\xampp\\htdocs\\result\\"
                path=path+str(i)+r".png"        
                if(response.status_code==requests.codes.not_found):
                    break
                file = open(path,"wb")
                    
                for chunk in response.iter_content(100000):
                        file.write(chunk)
                if(i==0):
                    i=i+1
                i=i+1
                file.close()
                    
            
        except:{
            print("finished")
        }
        time.sleep(5)
        

   

# ファイルをローカルに書き込む
   
    
# ファイル保存完了


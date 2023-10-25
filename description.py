import apache_log_parser
from pprint import pprint
import PySimpleGUI as sg
from datetime import datetime, timedelta, timezone
import matplotlib.pyplot as plt


def tracker(url):
    i=0
    output=""
    rename=["パワー","スピード","スタミナ","スコア1","スコア2","射的のスコア"]
    for key in statuslist.keys():
            output=output+"  "+rename[i]+"は"+str(statuslist[key])+"です"
            i=i+1
    print(output)
    print("           ↓↓↓")
    indexlist = {"speed":url.find("speed="),"stamina":url.find("stamina="),"power":url.find("power="),
                "score1":url.find("score1="),"score2":url.find("score2="),
                "syateki_score":url.find("syateki_score=")}
    url=url.split("&")
    for key in indexlist.keys():
        if(indexlist[key]!=0):
            for indiv in url:
                a=indiv.find(key)
                if(a!=-1):
                    statuslist[key]=int(indiv[a+1+len(key):])+int(statuslist[key])
    output=""
    i=0
    for key in statuslist.keys():
            output=output+"  "+rename[i]+"は"+str(statuslist[key])+"です"
            if(key=="speed"):
                plot_speed.append(statuslist["speed"])
            elif(key=="power"):
                plot_power.append(statuslist["power"])
            elif(key=="stamina"):
                plot_stamina.append(statuslist["stamina"])
            i=i+1
    
    print(output)    

def read_apache_log(ifn, logformat='%h %l %u %t \"%r\" %>s %b \"%{Referer}i\" \"%{User-Agent}i\"'):
    parser = apache_log_parser.make_parser(logformat)
    A=[]
    P = []
    E = []
    with open(ifn) as f:
        for line in f:
            try:
                parsed_line = parser(line)
                P.append(parsed_line)
            except ValueError:
                E.append(line)

    pprint('=== Read Summary ===')
    pprint('Parsed     : {0}'.format(len(P)))
    pprint('ValueError : {0}'.format(len(E)))
    pprint('====================')
    for p in P:
        if(p["status"]=="200"):
            A.append({"remote_host":p["remote_host"]
            ,"time_received_datetimeobj":p["time_received_datetimeobj"]
            ,"request_url":p["request_url"]})
    return A

def indentify_host(ip):
    hostlist={"127.0.0.1":"db","192.168.11.4":"GNCT","192.168.11.5":"GNCT","192.168.11.6":"panti",
            "192.168.11.7":"panti","192.168.11.8":"syateki","192.168.11.9":"syateki","192.168.11.10":"meikyu","192.168.11.12":"meikyu","192.168.11.3":"slot","192.168.11.13":"slot"}
    hostname=hostlist[ip]
    return hostname

def identifier(requestlist,id_query,id):
    for a in requestlist:
        b=a["request_url"]
        index=b.find(str(id_query))

        if index!=-1:

            try:
                if(b[index+len(id)+3]=="&"):
                    host=indentify_host(str(a["remote_host"]))
                    
            except:
                host=indentify_host(str(a["remote_host"]))
            
            mydate = a["time_received_datetimeobj"].time()
            status=""
            c=a["request_url"]
            if (("read" in c) or ("rank" in c) or ("score" in c) or ("image" in c)):
                status="読み込み"
            else:
                status="書き込み"
                plot_host.append(host)
                print("  |{0}|{1}|{2}|  ".format(host.center(14," "),str(mydate).center(19," "),status.center(20," ")))
            
            
            if(status=="書き込み"):
                print("詳細処理")
                tracker(b)
                print("\n")

requestlist=[]
ifn = 'C:\\xampp\\apache\\logs\\access.log'  ## 100行のログファイル
requestlist=read_apache_log(ifn)


sg.theme('Reddit')   # デザインテーマの設定

# ウィンドウに配置するコンポーネント
layout = [  [sg.Text('idを入力すると通信が表示されます')],
            [sg.Text('id'), sg.InputText()],
            [sg.Button('OK'), sg.Button('キャンセル'),sg.Button("プロット")],
            [sg.Output(size=(120,20),font=('Arial',20))]  ]
# ウィンドウの生成
plot_speed=[0]
plot_power=[0]
plot_stamina=[0]
plot_host=[""]
window = sg.Window('db cotroller', layout,resizable=True)
statuslist={"power":0,"speed":0,"stamina":0,"score1":0,"score2":0,"syateki_score":0}
# イベントループ
while True:
    event, values = window.read()
    
    if event == sg.WIN_CLOSED or event == 'キャンセル':
        

        break
    elif event == 'OK':
        statuslist={"power":0,"speed":0,"stamina":0,"score1":0,"score2":0,"syateki_score":0}
        print("-------------------------------------------------------------------------------------------------------------------------------------")
        print("     通信元             時間          値の更新or読み込み   ")
        id=str(values[0])
        id_query="id="+str(values[0])
        identifier(requestlist,id_query,id)
        
    elif event=="プロット":
        plt.plot(plot_host, plot_power, label='power')
        plt.plot(plot_host, plot_speed, label='speed')
        plt.plot(plot_host, plot_stamina, label='stamina')
        plt.legend(loc='best')
        plt.show()
        
        
        
window.close()

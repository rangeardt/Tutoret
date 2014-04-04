import os;
from lxml import etree;
import sys;
import json;
import MySQLdb;
import time;
import difflib;
import socket
from ftplib import FTP

def qui():
    User=os.popen("whoami")
    User=User.read()
    User=User.replace('\n','')
    return User

def applications(tabs):
    tabrep={}
    for i in tabs:
        tabrep[i]=int(os.popen("ps aux | grep -e "+i+" | grep -v color | wc -l").read())-1
    return tabrep

def application(nom):
    res=int(os.popen("ps aux | grep -e "+nom.replace('\n','')+" | grep -v color | wc -l").read())-1
    return res 

def salle():
    salle=os.popen("hostname | cut -d'-' -f1");
    salle=salle.read()
    salle=salle.replace('\n','')
    return salle;

def numpc():
    num=os.popen("hostname | cut -d'-' -f2");
    num=num.read()
    num=num.replace('\n','')
    return int(num);

def Recup_id_salle(cursor,numsalle):
    sql = "SELECT id FROM Salle \
       WHERE identificateur='%s'" % (numsalle)
    try:
        cursor.execute(sql);
        if(cursor.rowcount!=1):
            print("Erreur plusieur Reponse Ou Pas de Rep -> Recup_id_salle");
            idsalle=None;
        else:
            results = cursor.fetchall()
            for row in results:
                idsalle=row[0]
    except:
        print "Erreur: fecth data -> Recup_id_salle"
    return idsalle;

def Recup_id_pc(cursor,idsalle,numpc):
    sql = "SELECT id FROM Ordinateur \
       WHERE salle_id='%d' and nom='%d'" % (idsalle,numpc)
    try:
        cursor.execute(sql);
        if(cursor.rowcount!=1):
            print("Erreur plusieur Reponse Ou Pas de Rep -> Recup_id_pc");
            idpc=None;
        else:
            results = cursor.fetchall()
            for row in results:
                idpc=row[0]
    except:
        print "Erreur: fecth data -> Recup_id_pc"
    return idpc;

def Recup_id_etu(cursor,nometu):
    sql = "SELECT id FROM Etudiant \
       WHERE nom='%s'" % (nometu)
    try:
        cursor.execute(sql);
        if(cursor.rowcount!=1):
            print("Erreur plusieur Reponse Ou Pas de Rep -> Recup_id_pc");
            idetu=None;
        else:
            results = cursor.fetchall()
            for row in results:
                idetu=row[0]
    except:
        print "Erreur: fecth data -> Recup_id_etu"
    return idetu;

#Ne pas oublie le Commit apres
def Edit_etat(cursor,idpc,etat):
    sql = "UPDATE Ordinateur SET etat='%d' \
       WHERE id='%d'" % (etat,idpc)
    try:
        cursor.execute(sql);
    except:
        print "Erreur: MAJ -> Edit_etat"

#Ne pas oublie le Commit apres
def Edit_OrdiEtu(cursor,idetu,idpc):
    if(idetu<1):
        sql = "UPDATE Ordinateur SET etudiant_id=NULL \
       WHERE id='%d'" % (idpc)
    else:
       sql = "UPDATE Ordinateur SET etudiant_id='%d' \
       WHERE id='%d'" % (idetu,idpc)
    try:
        cursor.execute(sql);
    except:
        print "Erreur: MAJ -> Edit_OrdiEtu"

def Exist_ConfigApplication(cursor,idconfig,idappli):
    sql = "SELECT etat FROM ConfigApplication \
       WHERE post_id='%d' and Application_id='%d'" % (idconfig,idappli)
    try:
        cursor.execute(sql);
        if(cursor.rowcount<1):
            return False;
        else:
            return True;
    except:
        print "Erreur: -> Exist_ConfigApplication"
    return idetu;



def Edit_ConfigApplication(cursor,idpc,idappli,etat):
    exist=Exist_ConfigApplication(cursor,idpc,idappli);
    if(exist):
        sql = "UPDATE ConfigApplication SET etat='%d' \
            WHERE post_id='%d' and Application_id='%d'" % (etat,idpc,idappli)
        try:
            cursor.execute(sql);
        except:
            print "Erreur: MAJ -> Edit_ConfigApplication"
    else :
        sql = "INSERT INTO ConfigApplication (post_id,Application_id,etat)\
                VALUES('%d','%d','%d')" % (idpc,idappli,etat);
        try:
            cursor.execute(sql);
        except:
            print "Erreur: INSERT -> Edit_ConfigApplication"
    

def Appli(cursor,cursor2,idpc):
    sql = "SELECT * FROM Application"
    try:
        cursor.execute(sql);
        results = cursor.fetchall()
        for row in results:            
            app=application(row[2]);
            if(app<1):
                Edit_ConfigApplication(cursor2,idpc,row[0],0);
            else:
                Edit_ConfigApplication(cursor2,idpc,row[0],1);
    except:
        print "Erreur: fecth data -> Appli"


def Reset_Appli(cursor,cursor2,idpc):
    sql = "SELECT * FROM Application"
    try:
        cursor.execute(sql);
        results = cursor.fetchall()
        for row in results:  
            sql2 = "UPDATE ConfigApplication SET etat=0 \
            WHERE post_id='%d' and Application_id='%d'" % (idpc,row[0])
            try:
                cursor2.execute(sql2);
            except:
                print "Erreur: MAJ -> Rest_Appli"
    except:
        print "Erreur: fecth data -> Rest_Appli"

def recup_liste(cursor):
    res=""
    req="SELECT * FROM Paquet"
    try:
        cursor.execute(req)
        if(cursor.rowcount>0):
            result=cursor.fetchall()
            for row in result:
                res=row[1]
                res=""" """+res
                res=res[1:]
        else:
            print("Erreur d'ouverture de la table PACKET")
    except:
        print("Impossible d'ouvrir la bdd")
    return res

def recup_local():
    cmd=os.popen("dpkg -l | sed -e \"s/\ \ */ /g\"| cut -d ' ' -f2,3 | tail -n +6")
    cmd=cmd.read()
    return cmd

def get_result(cursor,idpc):
    l1=recup_liste(cursor)
    l1=l1.splitlines()
    l2=recup_local()
    l2=l2.splitlines()
    d=difflib.Differ()
    diff = d.compare(l1,l2)
    result='\n'.join(diff)
   
    sql = "UPDATE Ordinateur SET text='%s' \
       WHERE id='%d'" % (result,idpc)
    try:
        cursor.execute(sql);
    except:
        print "Erreur: MAJ -> get_result"



#RAillat
def Exist_ConfigServices(cursor,idconfig,idservice):
    sql = "SELECT etat FROM ConfigServices \
       WHERE post_id='%d' and service_id='%d'" % (idconfig,idservice)
    try:
        cursor.execute(sql);
        if(cursor.rowcount<1):
            return False;
        else:
            return True;
    except:
        print "Erreur: -> Exist_ConfigService"
    return False;



def Edit_ConfigServices(cursor,idpc,idservice,etat):
    exist=Exist_ConfigServices(cursor,idpc,idservice);
    if(exist):
        sql = "UPDATE ConfigServices SET etat='%d' \
            WHERE post_id='%d' and service_id='%d'" % (etat,idpc,idservice)
        try:
            cursor.execute(sql);
        except:
            print "Erreur: MAJ -> Edit_ConfigService"
    else :
        sql = "INSERT INTO ConfigServices (post_id,service_id,etat)\
                VALUES('%d','%d','%d')" % (idpc,idservice,etat);
        try:
            cursor.execute(sql);
        except:
            print "Erreur: INSERT -> Edit_ConfigService"



def getPageAccueil():
    try:
        socket.setdefaulttimeout(2)
        s = socket.socket()
        s.connect(("192.168.82.146",80))
        s.sendall(b'GET / \n')
        ans = s.recv(1024)
        return 1
    except:
        return 0
#return res (etat)

def banner():
    try:
        ftp = FTP('servinfo-cfe')
        welcome = ftp.welcome
        ftp.quit()
        return 1
    except:       
        return 0

def cups():
    cmd=int(os.popen("netstat -l | grep -e cups | grep -v color | wc -l").read().replace('\n',''))
    if(cmd>=1):
        return 1
    else:
        return 0

def cfengine():
    cmd=int(os.popen("ps aux | grep -e cfengine| grep -v color | wc -l").read().replace('\n',''))
    if(cmd>=3):
        return 1
    else:
        return 0

def service(cursor,idpc):
    sql = "SELECT * FROM Service"
    try:
        cursor.execute(sql);
        results = cursor.fetchall()
        for row in results:
            idserv=row[0]
            nom=row[2]
            fct=row[3]
            if(fct=="getPageAccueil"):
                res=getPageAccueil()
                Edit_ConfigServices(cursor,idpc,idserv,res)
            elif(fct=="banner"):
                #res=banner()
                #Edit_ConfigServices(cursor,idpc,idserv,res)
                print("need ssh")
            elif(fct=="cups"):
                res=cups()
                Edit_ConfigServices(cursor,idpc,idserv,res)
            elif(fct=="cfengine"):
                res=cfengine()
                Edit_ConfigServices(cursor,idpc,idserv,res)
    except:
        print "Erreur: fecth data -> Service"




































def InsertionBDD():
    db = MySQLdb.connect("info2", "rangeard", "rangeard", "DBrangeard")
    cursor = db.cursor()
    cursor2 = db.cursor()
    #Recuperer Num salle -> id salle
    #Num Pc
    #Check que l'etat est a deux
    #les deux -> id pc && configpost
    #Recup Nometu -> idEtu
    #Mis a jour ConfigPost(idetu)
    idsalle=Recup_id_salle(cursor,salle())#info27 -> salle()

    if(idsalle!=None):
        idpc=Recup_id_pc(cursor,idsalle,numpc())
        if(idpc!=None):
            service(cursor,idpc)
            Edit_etat(cursor,idpc,2);
            db.commit()
            idetu=Recup_id_etu(cursor,qui())#rangeard -> qui()
            if(idetu!=None):
                get_result(cursor,idpc)
                Edit_OrdiEtu(cursor,idetu,idpc)
                db.commit()
                while(1):
                    Appli(cursor,cursor2,idpc);
                    db.commit()
                    time.sleep(60)
                 #Fin Prog:
                Edit_etat(cursor,idpc,1);
                Edit_OrdiEtu(cursor,0,idpc);
                Reset_Appli(cursor,cursor2,idpc);
                db.commit()
            else:
                print("Erreur idetu");                    
        else:
            print("Erreur idpc");
    else:
        print("Erreur idsalle");
    db.close()


#Fermeture du service mise a 1 de l'etat
InsertionBDD();




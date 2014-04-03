import os;
from lxml import etree;
import sys;
import json;
import MySQLdb;
import time;
import difflib;

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
    res=int(os.popen("ps aux | grep -e "+nom+" | grep -v color | wc -l").read())-1
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

def recup_liste():
    db = MySQLdb.connect("info2", "rangeard", "rangeard", "DBrangeard")
    cursor = db.cursor()
    res=""
    req="SELECT * FROM paquet"
    try:
        cursor.execute(req)
        if(cursor.rowcount>0):
            result=cursor.fetchall()
           # print(result[0])
            for row in result:
                res=row[1]
                res=""" """+res
                res=res[1:]
                print(res)
        #else:
           # print("Erreur d'ouverture de la table PACKET")
        db.close()
    except:
        print("Impossible d'ouvrir la bdd")
    return res

def recup_local():
    cmd=os.popen("dpkg -l | sed -e \"s/\ \ */ /g\"| cut -d ' ' -f2,3| head -n -5")
    cmd=cmd.read()
    return cmd

def get_result(cursor,idpc):
    l1=recup_liste()
    l1=l1.splitlines()
    l2=recup_local()
    l2=l2.splitlines()
    d=difflib.Differ()
    diff = d.compare(l1,l2)
    result='\n'.join(diff)
    result=result.replace('+ ',"Paquet supplementaire : ")
    result=result.replace('- ',"Paquet manquant : ")
   
    sql = "UPDATE Ordinateur SET text='%s' \
       WHERE id='%d'" % (result,idpc)
    try:
        cursor.execute(sql);
    except:
        print "Erreur: MAJ -> get_result"


def InsertionBDD():
    db = MySQLdb.connect("info2", "rangeard", "rangeard", "DBrangeard")
    cursor = db.cursor()
    cursor2 = db.cursor()
    #Recuperer Num salle -> Id salle
    #Num Pc
    #Check que l'etat est a deux
    #les deux -> id pc && configpost
    #Recup Nometu -> idEtu
    #Mis a jour ConfigPost(idetu)
    idsalle=Recup_id_salle(cursor,salle())#info27 -> salle()
    if(idsalle!=None):        
        idpc=Recup_id_pc(cursor,idsalle,numpc());
        if(idpc!=None):
            Edit_etat(cursor,idpc,2);
            db.commit()
            idetu=Recup_id_etu(cursor,qui());#rangeard -> qui()
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




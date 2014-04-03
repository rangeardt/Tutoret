import os;
from lxml import etree;
import sys;
import json;
import MySQLdb;
import time;

def get_id_image(url,cursor):
	id_image=None;
	try:
		sql="SELECT id FROM Image \
       WHERE url='%s'" % (url)
		cursor.execute(sql)
		results=cursor.fetchall()
		for row in results:
			id_image=row[0]
	except:
		print "Erreur: fecth data -> get_id_image"	
	return id_image	


def add_image(db,url,alt,cursor):
	try:
		sql = "INSERT into Image (url,alt) VALUES('%s','%s')" % (url,alt)
		cursor.execute(sql)
		db.commit()
	except:
		print "Erreur: fecth data -> add_image"
	return get_id_image(url,cursor)

def ajout_photo():
	db = MySQLdb.connect("info2", "rangeard", "rangeard", "DBrangeard")
	cursor = db.cursor()
	cursor2 = db.cursor()
	id_image=0;
	sql = "SELECT id,nom,numero,image_id FROM Etudiant"
	try:
		cursor.execute(sql);
		if(cursor.rowcount<1):
			print("Aucune etudiant dans la BDD")
		else:
			results = cursor.fetchall()
			for row in results:
				if(row[3] == None):
					idetu=row[0]
					nom=row[1]
					numero=row[2]
					lien="http://pocal.univ-orleans.fr/trombi/photos_etudiants/o"+numero[0:3]+"/"+numero+"Apog0450855K.jpg"
					id_image = add_image(db,lien,nom,cursor2)
					update="UPDATE Etudiant SET image_id='%d' \
                                WHERE id='%s'" % (id_image,idetu)
					cursor2.execute(update);
				else : 
					print("Existe deja");
		db.commit();
		db.close()
	except:
		print "Erreur: fecth data -> Ajout_photo"


ajout_photo()

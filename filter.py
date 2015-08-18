#!/usr/bin/python

import os
import heapq
import cv2
import numpy as np
import MySQLdb

db = MySQLdb.connect(user='tone', passwd='su9BfbRYN3PSPE6N', db='tone')
cx = db.cursor()

def deleteCase(ID):
	cx.execute('DELETE FROM `record` WHERE `ID` = %s', ID)
	os.remove("/var/www/simple/%s_simple.jpg" % ID)
	os.remove("/var/www/fusion/%s_fusion.jpg" % ID)
	print('delete', ID)

path = '/var/www/simple/'

# first round, fast check based on file name suffex and countNonZero
IDList = [f[:f.rindex('_')] for f in os.listdir(path)]
group = {}
for ID in IDList:
	main = ID[:ID.rindex('.')]
	sufix = ID[(ID.rindex('.')+1):]
	if group.get(main):
		group[main].append(sufix)
	else:
		group[main] = [sufix]

for main, suffixList in group.items():
	tmp = []
	for suffix in suffixList:
		ID = '%s.%s' % (main, suffix)
		filename = '/var/www/simple/%s_simple.jpg' % ID
		img = cv2.imread(filename, 0)
		rate = float(cv2.countNonZero(img)) / img.size
		if rate > 0.9:
			heapq.heappush(tmp, (rate, ID))
		else:
			deleteCase(ID)

	for i in range(len(tmp) -1):
		ID = heapq.heappop(tmp)[1]
		deleteCase(ID)

# second round, slow check based on absdiff
IDSizeList = [[os.stat('/var/www/simple/%s' % f).st_size, f[:f.rindex('_')]] for f in os.listdir(path)]
IDSizeList.sort()
IDSizeListSize = len(IDSizeList)

for i in range(len(IDSizeList) - 1):
	thisRow = IDSizeList[i    ]
	nextRow = IDSizeList[i + 1]
	if (thisRow[0] * 1.1 > nextRow[0]):
		thisFile = '/var/www/simple/%s_simple.jpg' % thisRow[1]
		nextFile = '/var/www/simple/%s_simple.jpg' % nextRow[1]
		thisImg = cv2.imread(thisFile, 0)
		nextImg = cv2.imread(nextFile, 0)
		if thisImg.shape == nextImg.shape:
			if (float(cv2.countNonZero(cv2.absdiff(thisImg, nextImg))) / thisImg.size) < 0.1:
				deleteCase(thisRow[1])
			else:
				print("Image absdiff too far")
		else:
			print("Image size dismatch")
	else:
		print("File size too far")

cx.close()
db.commit()
db.close()

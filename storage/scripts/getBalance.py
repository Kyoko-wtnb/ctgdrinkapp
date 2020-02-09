#!/usr/bin/python
import sys
import os
import numpy as np
import json
import sqlite3

##### Return index of a1 which exists in a2 #####
def ArrayIn(a1, a2):
	return np.where(np.in1d(a1, a2))[0]

def main():
	### connect to DB
	db = sys.argv[1]
	conn = sqlite3.connect(db)
	c = conn.cursor()

	### extract all members
	out = []
	for row in c.execute('SELECT vunetid, name FROM members WHERE state="active" ORDER BY vunetid'):
		out.append([str(row[0]), str(row[1])])
	out = np.c_[out, [0.0]*len(out), [0.0]*len(out), ["null"]*len(out)]

	### add balance
	tmp = []
	for row in c.execute('SELECT vunetid, sum(deposit) FROM deposits WHERE status="APPROVED" GROUP BY vunetid ORDER BY vunetid'):
		if str(row[0]) in out[:,0]: tmp.append([str(row[0]), str(row[1])])
	tmp = np.array(tmp)

	ind = ArrayIn(out[:,0], tmp[:,0])
	out[ind, 2] = np.add(out[ind, 2].astype(float),tmp[:,1].astype(float))

	tmp = []
	for row in c.execute('SELECT vunetid, sum(cost) FROM drinks GROUP BY vunetid ORDER BY vunetid'):
		if str(row[0]) in out[:,0]: tmp.append([str(row[0]), str(row[1])])
	tmp = np.array(tmp)
	if len(tmp)>0:
		ind = ArrayIn(out[:,0], tmp[:,0])
		out[ind, 2] = np.subtract(out[ind, 2].astype(float),tmp[:,1].astype(float))

	### add pending deposit
	tmp = []
	for row in c.execute('SELECT vunetid, sum(deposit) FROM deposits WHERE status="PENDING" GROUP BY vunetid ORDER BY vunetid'):
		if str(row[0]) in out[:,0]: tmp.append([str(row[0]), str(row[1])])
	tmp = np.array(tmp)
	if len(tmp)>0:
		ind = ArrayIn(out[:,0], tmp[:,0])
		out[ind, 3] = np.add(out[ind, 3].astype(float),tmp[:,1].astype(float))

	### add most recent drink
	tmp = []
	for row in c.execute('SELECT vunetid, max(date) FROM drinks GROUP BY vunetid ORDER BY vunetid'):
		if str(row[0]) in out[:,0]: tmp.append([str(row[0]), str(row[1])])
	tmp = np.array(tmp)
	if len(tmp)>0:
		ind = ArrayIn(out[:,0], tmp[:,0])
		out[ind, 4] = tmp[:,1]

	print json.dumps({"data":out.tolist()})

if __name__ == "__main__": main()

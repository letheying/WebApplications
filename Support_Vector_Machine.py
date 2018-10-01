# Written by: Shi Wang
# Assisted by: Hairong Wang
# Debugged by: Ying Liu
# -*- coding: utf-8 -*-
from sklearn.svm import SVR 
import numpy as np
import sys



dates = []
prices = []
prices = sys.argv[1].split()
days = int(sys.argv[2])
for i in range(0, len(prices)):
    prices[i] = float(prices[i])
    dates.append(i+1)
dates = np.reshape(dates, (len(dates), 1))
svr_rbf = SVR(kernel='rbf', C=1e3, gamma=0.1)
svr_rbf.fit(dates, prices)

print (round(svr_rbf.predict(len(prices)+days)[0],2))



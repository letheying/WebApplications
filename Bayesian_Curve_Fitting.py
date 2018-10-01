# Written by: Ying Liu
# Assisted by: Shi Wang
# Debugged by: Hairong Wang
# -*- coding: utf-8 -*-
import numpy as np
import sys

#LOAD PRICE
Price = []

Price = sys.argv[1].split()
for i in range(0, len(Price)):
    Price[i] = float(Price[i])

#Price1 = [39.99,40.32,40.22,40.29,40.51,40.2,40.38,40.60,40.60,41.05,41.73,41.75,41.60,41.80,41.39,41.54,41.41,41.59,41.76,41.63,42.10,42.45]
#print(Price)
#print(Price1)
#INITIALIZATION

[Beta,Alpha] = [11.1,0.005]
Day_T = len(Price)   # Day_T:Number of Tranning data. Day_P: Number of predictions you want to make.
Day_P = int(sys.argv[2])


TrainingTime = range(1, Day_T + 1) # get training set x
PTime = range(1, Day_T + Day_P + 1) 
TrainingPrice = Price[-Day_T:] # get training set t

#TrainingPrice = Price[:Day_T]

#GET THE NORMALIZTION DISTRIBUTION
# **************************Function for calculate phi ********************************** #
M = 6 #how many bases you want in your polynomial fitting
def phi(x):
    Index = np.mat(range(0, M + 1))
    phi_x = np.power(x, Index).T
    return phi_x


# *********************** Function for calculate sum of phi(xn) ************************* #
def sum_phi_xn(xn):
    sum_phi_xn = np.mat(np.zeros([M+1, M+1]))
    for i in range(0, len(xn)):
        sum_phi_xn = sum_phi_xn + phi(xn[i])*phi(xn[i]).T
    return sum_phi_xn


# ********************* Function for calculate the sum of phi(xn)*tn ******************** #
def sum_phi_xn_tn(xn, tn):
    sum_phi_xn_tn = np.mat(np.zeros([M + 1, 1]))
    for i in range(0, len(xn)):
        sum_phi_xn_tn = sum_phi_xn_tn + phi(xn[i]) * tn[i]
    return sum_phi_xn_tn


# ***************************** Function for calculate S-1 ****************************** #
def s_inverse(xn):
    s_inverse = Alpha * np.mat(np.identity(M + 1)) + Beta * sum_phi_xn(xn)
    return s_inverse


# ************************* Function for calculate m(x) ********************************* #
def m_x(xn, tn, x):
    mx = Beta * phi(x).T * np.linalg.pinv(s_inverse(xn)) * sum_phi_xn_tn(xn, tn)
    return mx


# *********************** Function for calculate S^2(x)  ******************************** #
def sigma_x2(xn, x):
    sigmax2 = (1/Beta) + phi(x).T * np.linalg.pinv(s_inverse(xn)) * phi(x)
    return sigmax2


#START PREDICTION
# *********************************** Normalization ************************************* #
NTestPrices = []
for i in range(0, Day_T):
    z = (TrainingPrice[i]-np.mean(TrainingPrice))/np.std(TrainingPrice) #normalized value
    NTestPrices.append(z)


# ******************************** Make prediction ************************************** #
#Initializing
L=len(PTime)
mu = np.mat(np.zeros([L, 1])) 
sigma = np.mat(np.zeros([L, 1])) 
x = np.mat(np.zeros([L, 1]))
PredictedPrice = np.mat(np.zeros([L, 1]))       

for i in range(0, len(PTime)):
    mu[i] = m_x(TrainingTime, NTestPrices, i+1)
    sigma[i] = np.sqrt(sigma_x2(TrainingTime, i+1))
    x[i] = sigma[i] * np.random.randn() + mu[i]
    PredictedPrice[i] = x[i]*np.std(TrainingPrice)+np.mean(TrainingPrice)  #Predicted price

#print mu,sigma
#print x
#print (Price)
a = str(PredictedPrice).replace('[','').replace(']','');
b=a.split('\n')
result = float(b[len(PTime)-1].strip())
TrainingPrice.append(round(result,2))
print(TrainingPrice[len(TrainingPrice)-1])


#print(PredictedPrice)


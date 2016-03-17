#!/bin/bash


echo "STOP"
tmux send-keys -t airpollution:0 C-c

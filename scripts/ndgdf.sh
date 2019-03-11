#!/usr/bin/env bash

SCENARIO_NAME="ndgforensics"

rm -rfv projects/$SECNARIO_NAME
ruby secgen.rb run --scenario scenarios/NDG/$SCENARIO_NAME.xml --project /home/sysadmin/bin/Th3Prim3/SecGen/projects/$SCENARIO_NAME

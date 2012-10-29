# called from pre-commit.py

import subprocess, string, os, sys, inspect

def sliceStrAndValue(stringToSearch, term):
	start = stringToSearch.find(term)
	index = stringToSearch[start:].find(",")
	if index > 0:
		end = start + index 
	else:
		end = len(stringToSearch)
	sliced = stringToSearch[start : end]
	chunks = string.split(sliced, " ", 2)
	return chunks[0], chunks[1]


def main():
	# return 0 for success, =\= 0 for failure
	test_folder = os.path.realpath(os.path.abspath(os.path.split(inspect.getfile( inspect.currentframe() ))[0]))
	os.chdir(test_folder)


	sub = subprocess.Popen("php test_suite.php", stdout=subprocess.PIPE, shell=True)
	output = sub.stdout.read()
	lines = string.split(output, '\n')
	result = lines[len(lines) - 2]

	run, numRun = sliceStrAndValue(result, "run")
	passes, numPasses = sliceStrAndValue(result, "Passes")
	failures, numFailures = sliceStrAndValue(result, "Failures")
	exceptions, numExceptions = sliceStrAndValue(result, "Exceptions")

	# debugging output
	# print numRun, numPasses, numFailures, numExceptions

	# show the results of the tests
	print output

	numFailures = int(numFailures)
	numExceptions = int(numExceptions)
	if numFailures > 0 or numExceptions > 0:
		return 1
	return 0


if __name__ == '__main__':
	main()


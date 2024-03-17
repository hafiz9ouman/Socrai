import string
from nltk.tokenize import word_tokenize
from nltk.corpus import stopwords
from nltk.stem import WordNetLemmatizer
import sys
import json
import nltk





def x(check_str):
	backtophp  = check_str
	# returnlst = ["question_id ",":",check_str]
	var =  json.dumps(backtophp)
	print(var)

#-------------------PRE PROCESSING-------------------------------------------------------------
def convert(lst): 
	return ([i for item in lst for i in item.split()]) 
	

def pre_process(my_str):
	# define punctuation
	my_str =  my_str.lower()
	punctuations = string.punctuation
	# remove punctuation from the string
	no_punct = ""
	
	for char in my_str:
		if char not in punctuations:
			no_punct = no_punct + char
	lst =  [no_punct]    
	text_tokens = convert(lst)

	
	# all_stop_words = stopwords.words('english')
	all_stop_words = ['i', 'me', 'my', 'myself', 'we', 'our', 'ours', 'ourselves', 'you', "you're", "you've", "you'll", "you'd", 'your', 'yours', 'yourself', 'yourselves', 'he', 'him', 'his', 'himself', 'she', "she's", 'her', 'hers', 'herself', 'it', "it's", 'its', 'itself', 'they', 'them', 'their', 'theirs', 'themselves', 'this', 'that', "that'll", 'am', 'is', 'are', 'was', 'were', 'be', 'been', 'being',  'doing', 'a', 'an', 'the', 'and', 'but','if', 'or', 'because', 'as', 'until', 'while', 'of', 'at', 'by', 'for', 'between', 'into', 'through', 'during', 'before', 'after', 'above', 'below', 'to', 'from', 'up', 'down', 'in', 'out', 'on', 'off', 'over',  'then', 'once', 'here','how', 'all', 'any', 'both', 'each',  'no', 'nor', 'not', 'only', 'own','so', 'than', 'too', 's', 't', 'don', "don't", "should've", 'now', 'd', 'll', 'm', 'o', 're', 've', 'y', 'ain', 'aren', "aren't", 'couldn', "couldn't", 'hadn', "hadn't", 'hasn', "hasn't", "haven't", 'isn', "isn't", 'ma']
	text_without_sw = []

	

	for word in text_tokens:
		if word not in all_stop_words:
			text_without_sw.append(word)
	return text_without_sw

#------------------JACCARD SIMILARITY-----------------------------------------------------------


def jaccard_similarity(s1, s2):
	rt = (len(s1.intersection(s2)) / len(s1.union(s2))) 
	return rt

def questions():
	question_list=[]
	# questions
	d1 = 'how many continents are there in the world?'
	d2 = 'Which is the largest ocean in the world?'
	d3 = 'What is population on the planet Earth?'
	d4 = 'What is the name of smallest country in the world?'
	d5 = 'What is highest or tallest mountain in the world?'
	question_list.append(d1)
	question_list.append(d2)
	question_list.append(d3)
	question_list.append(d4)
	question_list.append(d5)
	return question_list


def answers():
	answer_list=[]
	#Answers
	a1='There are seven continents on planet Earth.'
	a2='Pacific Ocean is known as the largest and deepest ocean in world.'
	a3='Its around 7.6 billion.'
	a4='Vatican City is known as smallest country in world and landlocked by Itlay.'
	a5='Mount Everst is highest mountain in world.'

	answer_list.append(a1)
	answer_list.append(a2)
	answer_list.append(a3)
	answer_list.append(a4)
	answer_list.append(a5)
	return answer_list


stored_score=0
def check_similarity(question_array, question_index):
# def check_similarity(asked_question):
	print("question_array",question_array)
	similarity_score_among_questions_list=[]
	similarity_score_among_questions_index = []

	all_questions= question_array
	asked_question = all_questions[len(all_questions)-1]
	all_questions = question_array[:(len(all_questions)-1)]
	
	
	s1 = pre_process(asked_question)


	# print("testing length ofquestions: ", len(all_questions))
	for i in range(len(all_questions)):
		s2 = pre_process(all_questions[i])
		s1 = set(s1)
		s2 = set(s2)
		a = jaccard_similarity(s1, s2)
		a=(int(round(a * 100)))
		# print(i)
		
		similarity_score_among_questions_list.append(a)
		similarity_score_among_questions_index.append(question_index[i])
		# print(similarity_score_among_questions_list)
		# stored_score += int(round(a * 100))
		# stored_score = stored_score / len(question_list)
	high_priority_question= int(max(similarity_score_among_questions_list))
	# print(high_priority_question)
	indexx=similarity_score_among_questions_list.index(high_priority_question)
	trueIndex = similarity_score_among_questions_index[indexx]

	# returnList = []
	# returnList.append("Most Similar Question index: "+str(indexx))
	# returnList.append("Most Similar Question: "+all_questions[indexx])
	# returnList.append("Confidence Level: "+str(high_priority_question))
	# returnList.append("Answer: "+all_answers[indexx])
	if high_priority_question <50:
		return '00'
	else:
		return str(trueIndex)
		# return str(indexx)

	# result_json = json.dumps("hello")
	# print(result_json)
	# return result_json




# user_question = ast.literal_eval(sys.argv[1])
# list2 = ast.literal_eval(sys.argv[2])
# user_question2 = []
# user_question = sys.argv
# user_question = user_question[1]
# print("before ", user_question)
# m = map(float, user_question.strip('[]').split(','))
# print("my",m)
import ast
import sys
# user_question=sys.argv[1]

print("before")
user_question = ast.literal_eval(sys.argv[1])
user_question_index = ast.literal_eval(sys.argv[2])
# print("type od whole input",type(user_question))
# for i in user_question:
# 	print("type of variable:", type(i))
print("before")



# list2 = ast.literal_eval(sys.argv[2])
# print(user_question)
# for i in user_question:
# 	print(i)
# 	print(type(i))
	# user_question2.append(str(i))

# user_question =  ["adsadsads what is your name","khsdsd","kjsdjhsgds","kjsdjhsgds"]
# user_question_index = [11,22,33,44]


# user_question = ['1', '2', '3', '4', '5', '6', '7', '8', '7']

# user_question =  user_question.split(',')
# print("after ", user_question)

# user_question = [\"asdlkj\",\"asdlkj\",\"1sdsdsdsd\",\"What is your native town\",\"what  name\"]
# user_question = ["jhgsjhgd","asdlkj"," sdsds dsbsb","sasa is your native town","what  name"]
# user_question = ["adsadsads what is your name","khsdsd","kjsdjhsgds","elo"]
# user_question = json.loads(json_data)
print(user_question)
print(user_question_index)
# user_question = "by which material a chair made?"
var1 = check_similarity(user_question,user_question_index)


#var = json.dumps("hh")
# print("hello")
# var = pre_process("good day man")
x(var1)
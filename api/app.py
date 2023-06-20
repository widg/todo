from flask import Flask, request, jsonify
from flask_mysqldb import MySQL
from flask_cors import CORS 

app = Flask(__name__)
CORS(app, resources={r"/api/*": {"origins": "http://localhost:8080"}}, methods=['GET', 'POST', 'PUT', 'DELETE'], allow_headers=['Content-Type'])



# Настройки подключения к базе данных MySQL
app.config['MYSQL_HOST'] = 'laravel-db'
app.config['MYSQL_USER'] = 'laravel'
app.config['MYSQL_PASSWORD'] = 'laravel'
app.config['MYSQL_DB'] = 'laravel'
app.config['MYSQL_CURSORCLASS'] = 'DictCursor'

# Инициализация расширения MySQL
mysql = MySQL(app)


# Создание задачи
@app.route('/api/tasks', methods=['POST'])
def create_task():
    title = request.json['title']
    description = False
    is_completed = False 
    cur = mysql.connection.cursor()
    cur.execute("INSERT INTO todos (title, description, is_completed) VALUES (%s, %s, %s)", (title, description, is_completed))
    mysql.connection.commit()
    cur.close()
    return jsonify({'message': 'Task created successfully'})


# Получение всех задач
@app.route('/api/tasks', methods=['GET'])
def get_all_tasks():
    cur = mysql.connection.cursor()
    cur.execute("SELECT * FROM todos")
    rows = cur.fetchall()
    cur.close()
    return jsonify(rows)


# Получение задачи по идентификатору
@app.route('/api/tasks/<int:task_id>', methods=['GET'])
def get_task(task_id):
    cur = mysql.connection.cursor()
    cur.execute("SELECT * FROM todos WHERE id = %s", (task_id,))
    row = cur.fetchone()
    cur.close()
    if row:
        return jsonify(row)
    else:
        return jsonify({'message': 'Task not found'}), 404


# Обновление задачи по идентификатору
@app.route('/api/tasks/<int:task_id>', methods=['PUT'])
def update_task(task_id):
    title = request.json['title']
    description = request.json['description']
    cur = mysql.connection.cursor()
    cur.execute("UPDATE todos SET title = %s, description = %s WHERE id = %s", (title, description, task_id))
    mysql.connection.commit()
    cur.close()
    return jsonify({'message': 'Task updated successfully'})


# Удаление задачи по идентификатору
@app.route('/api/tasks/<int:task_id>', methods=['DELETE'])
def delete_task(task_id):
    cur = mysql.connection.cursor()
    cur.execute("DELETE FROM todos WHERE id = %s", (task_id,))
    mysql.connection.commit()
    cur.close()
    return jsonify({'message': 'Task deleted successfully'})


if __name__ == '__main__':
    app.run(host='0.0.0.0', debug=True)


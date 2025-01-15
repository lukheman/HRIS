from faker import Faker
import mysql.connector
from datetime import datetime, timedelta
import random

# Initialize Faker
fake = Faker('id_ID')  # Using Indonesian locale since the column names are in Indonesian

# MySQL Connection Configuration
db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': 'akmal',
    'database': 'fbs',
    'charset': 'utf8mb4',
    'collation': 'utf8mb4_general_ci'
}

# List of possible positions
jabatan_list = [
    'Manager', 'Supervisor', 'Staff', 'Administrator',
    'Kepala Divisi', 'Direktur', 'Asisten Manager',
    'Senior Staff', 'Junior Staff', 'Koordinator'
]

def generate_nik():
    """Generate a unique NIK format"""
    return f"{fake.random_number(digits=16, fix_len=True)}"

def generate_salary(jabatan):
    """Generate salary based on position"""
    salary_ranges = {
        'Direktur': 15000000,
        'Manager': 10000000,
        'Kepala Divisi': 8000000,
        'Supervisor': 6000000,
        'Senior Staff': 5000000,
        'Asisten Manager': 7000000,
        'Staff': 4000000,
        'Junior Staff': 3500000,
        'Administrator': 4000000,
        'Koordinator': 5000000
    }
    return salary_ranges[jabatan]

def insert_dummy_data(num_records):
    try:
        # Establish database connection
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor()

        # Insert dummy records
        for _ in range(num_records):
            jabatan = random.choice(jabatan_list)
            data = {
                'nama': fake.name(),
                'nik': generate_nik(),
                'tanggal_lahir': fake.date_of_birth(minimum_age=18, maximum_age=65).strftime('%Y-%m-%d'),
                'alamat': fake.address(),
                'jabatan': jabatan,
                'gaji': generate_salary(jabatan)
            }

            # SQL Insert query
            insert_query = """
                INSERT INTO tb_karyawan (nama, nik, tanggal_lahir, alamat, jabatan, gaji)
                VALUES (%(nama)s, %(nik)s, %(tanggal_lahir)s, %(alamat)s, %(jabatan)s, %(gaji)s)
            """

            cursor.execute(insert_query, data)

        # Commit the changes
        conn.commit()
        print(f"Successfully inserted {num_records} dummy records")

    except mysql.connector.Error as error:
        print(f"Failed to insert records into MySQL table: {error}")


def get_employee_ids():
    """Fetch all employee IDs from tb_karyawan"""
    try:
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor()
        cursor.execute("SELECT id FROM tb_karyawan")
        employee_ids = [row[0] for row in cursor.fetchall()]
        return employee_ids
    except Exception as e:
      print('tidak ada karyawan_id', e)
      exit()

    # finally:
    #     if conn.is_connected():
    #         cursor.close()
    #         conn.close()

def generate_time(base_time, variation_minutes):
    """Generate a time with some random variation"""
    minutes_to_add = random.randint(-variation_minutes, variation_minutes)
    return (datetime.strptime(base_time, '%H:%M') +
            timedelta(minutes=minutes_to_add)).strftime('%H:%M')

def generate_attendance_status():
    """Generate attendance status with weighted probabilities"""
    statuses = ['Hadir', 'Alpha']
    weights = [0.95, 0.05]  # 95% Hadir, 5% Alpha
    return random.choices(statuses, weights=weights)[0]

def generate_attendance_records(start_date, end_date, employee_ids):
    """Generate attendance records for the given date range"""
    current_date = start_date
    records = []

    while current_date <= end_date:
        # Skip weekends
        if current_date.weekday() < 5:  # Monday = 0, Sunday = 6
            for emp_id in employee_ids:
                status = generate_attendance_status()

                if status == 'Hadir':
                    # Generate regular attendance times
                    jam_masuk = generate_time('08:00', 30)  # 30 minutes variation
                    jam_keluar = generate_time('17:00', 30)

                    # Randomly decide if there's overtime (20% chance)
                    lembur = random.choices(
                        [0, random.randint(30, 180)],  # 0 or 30-180 minutes
                        weights=[0.8, 0.2]
                    )[0]

                    if lembur > 0:
                        # Adjust jam_keluar for overtime
                        base_time = datetime.strptime(jam_keluar, '%H:%M')
                        jam_keluar = (base_time + timedelta(minutes=lembur)).strftime('%H:%M')
                else:
                    # For 'Alpha', set standard times
                    jam_masuk = '00:00'
                    jam_keluar = '00:00'
                    lembur = 0

                records.append({
                    'karyawan_id': emp_id,
                    'tanggal': current_date.strftime('%Y-%m-%d'),
                    'jam_masuk': jam_masuk,
                    'jam_keluar': jam_keluar,
                    'lembur': lembur,
                    'status': status
                })

        current_date += timedelta(days=1)

    return records

def insert_attendance_records(records):
    """Insert attendance records into the database"""
    try:
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor()

        # Set the correct charset and collation
        cursor.execute('SET NAMES utf8mb4')
        cursor.execute('SET CHARACTER SET utf8mb4')
        cursor.execute('SET character_set_connection=utf8mb4')

        insert_query = """
            INSERT INTO tb_absensi
            (karyawan_id, tanggal, jam_masuk, jam_keluar, lembur, status)
            VALUES (%(karyawan_id)s, %(tanggal)s, %(jam_masuk)s, %(jam_keluar)s,
                    %(lembur)s, %(status)s)
        """

        for record in records:
            cursor.execute(insert_query, record)

        conn.commit()
        print(f"Successfully inserted {len(records)} attendance records")

    except mysql.connector.Error as error:
        print(f"Failed to insert records into MySQL table: {error}")


def main():
    # Get all employee IDs
    employee_ids = get_employee_ids()
    print(employee_ids)

    if not employee_ids:
        print("No employees found in the database!")
        return

    # Generate attendance for the last 30 days
    end_date = datetime.now().date()
    start_date = end_date - timedelta(days=90)
    # start_date = datetime.now().date()

    print(f"Generating attendance records from {start_date} to {end_date}")
    records = generate_attendance_records(start_date, end_date, employee_ids)

    # Insert the records
    insert_attendance_records(records)

if __name__ == "__main__":
    main()

# if __name__ == "__main__":
#     # Generate 100 dummy records
#     insert_dummy_data(20)

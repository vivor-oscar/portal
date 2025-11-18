-- Archived SQL for creating sms_logs table (feature paused)
-- Original migration preserved here.

-- Create table for SMS logs
CREATE TABLE IF NOT EXISTS sms_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  to_number VARCHAR(50) NOT NULL,
  normalized_number VARCHAR(50) DEFAULT NULL,
  message TEXT,
  twilio_sid VARCHAR(100) DEFAULT NULL,
  status VARCHAR(50) DEFAULT NULL,
  error TEXT DEFAULT NULL,
  sent_by VARCHAR(100) DEFAULT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX (normalized_number),
  INDEX (twilio_sid)
);

#!/usr/bin/ruby
$: << File.expand_path("../../lib", __FILE__)
require_relative '../../../../../lib/objects/local_string_encoder.rb'
require 'packetfu'
require 'faker'
require 'rubygems'

class PcapGenerator < StringEncoder
  attr_accessor :strings_to_leak

  def initialize
    super
    self.module_name = 'PCAP Generator / Builder'
    self.strings_to_leak = []
  end

  def encode_all
    # Create an array of packets
    @pcaps = []
    data = self.strings_to_leak.join("\n")
    pkt = PacketFu::TCPPacket.new
    # Create fake mac addresses for sender and receiver
    pkt.eth_saddr=Faker::Internet.mac_address
    pkt.eth_daddr=Faker::Internet.mac_address
    # Create fake Public IP addresses for sender and receiver
    pkt.ip_src=PacketFu::Octets.new.read_quad(Faker::Internet.public_ip_v4_address)
    pkt.ip_dst=PacketFu::Octets.new.read_quad(Faker::Internet.public_ip_v4_address)
    pkt.payload = data
    pkt.recalc
    @pcaps << pkt
    file_contents = ''
    pfile = PacketFu::PcapFile.new
    pcap_file_path = GENERATORS_DIR + 'network/pcap/files/packet.pcap'
    res = pfile.array_to_file(:filename => pcap_file_path, :array => @pcaps, :append => true)
    file_contents = File.binread(pcap_file_path)
    File.delete(pcap_file_path)
    self.outputs << Base64.strict_encode64(file_contents)
  end

  def get_options_array
    super + [['--strings_to_leak', GetoptLong::OPTIONAL_ARGUMENT]]
  end

  def process_options(opt, arg)
    super
    case opt
      when '--strings_to_leak'
        self.strings_to_leak << arg;
    end
  end

  def encoding_print_string
    'strings_to_leak: ' + self.strings_to_leak.to_s
  end
end

PcapGenerator.new.run